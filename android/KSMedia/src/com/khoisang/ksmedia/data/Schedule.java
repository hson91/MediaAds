package com.khoisang.ksmedia.data;

import java.util.ArrayList;
import java.util.List;

import android.content.Context;

public class Schedule {
	public int scheduleID;
	public int type;
	public long timeStart;
	public long timeEnd;
	public List<Video> video;

	public List<Video> getListVideo() {
		if (video == null)
			video = new ArrayList<Video>();
		return video;
	}

	public void setListVideo(List<Video> video) {
		this.video = video;
	}

	public void initWhenOnline() {
		this.timeEnd = this.timeEnd * 1000;
		this.timeStart = this.timeStart * 1000;
	}

	public void copy(Schedule object) {
		this.scheduleID = object.scheduleID;
		this.type = object.type;
		this.timeStart = object.timeStart;
		this.timeEnd = object.timeEnd;
		//
		this.getListVideo().clear();
		this.getListVideo().addAll(object.getListVideo());
	}

	public static Schedule containSchedule(List<Schedule> listSchedule, Schedule schedule) {
		for (int i = 0; listSchedule != null && schedule != null && i < listSchedule.size(); i++) {
			Schedule tempSchedule = listSchedule.get(i);
			if (tempSchedule.scheduleID == schedule.scheduleID)
				return tempSchedule;
		}
		return null;
	}

	public static void copy(Context context, List<Schedule> newListSchedule, List<Schedule> oldSchedule) {
		if (newListSchedule != null && newListSchedule.size() > 0) {
			// for loop - add + updating
			for (int i = 0; i < newListSchedule.size(); i++) {
				Schedule tempSchedule = newListSchedule.get(i);
				if (tempSchedule != null) {
					List<Video> listVideo = tempSchedule.getListVideo();
					for (int j = 0; listVideo != null && j < listVideo.size(); j++) {
						Video tempVideo = listVideo.get(j);
						if (tempVideo != null)
							tempVideo.initWhenOnline(context);
					}

					tempSchedule.initWhenOnline();
					Schedule scheduleInList = Schedule.containSchedule(oldSchedule, tempSchedule);
					if (scheduleInList == null)
						oldSchedule.add(tempSchedule);
					else {
						scheduleInList.copy(tempSchedule);
					}
				}
			}
			// for loop - remove
			for (int i = 0; i < oldSchedule.size(); i++) {
				Schedule schedule = oldSchedule.get(i);
				Schedule scheduleInList = Schedule.containSchedule(newListSchedule, schedule);
				if (scheduleInList == null) {
					oldSchedule.remove(i);
					i--;
				}
			} // End for
		} else {
			oldSchedule.clear();
		}
	}
}
