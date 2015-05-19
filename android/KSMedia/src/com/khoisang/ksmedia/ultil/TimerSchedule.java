package com.khoisang.ksmedia.ultil;

import java.lang.ref.WeakReference;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;

import android.content.Context;
import android.os.Handler;
import android.os.Message;

import com.google.gson.Gson;
import com.khoisang.khoisanglibary.date.TimeStampUtil;
import com.khoisang.khoisanglibary.network.HttpDownloadManager;
import com.khoisang.khoisanglibary.network.HttpHandler;
import com.khoisang.ksmedia.api.ApiManager;
import com.khoisang.ksmedia.api.structure.InputError;
import com.khoisang.ksmedia.api.structure.InputGetVideo;
import com.khoisang.ksmedia.constant.APIName;
import com.khoisang.ksmedia.data.Schedule;
import com.khoisang.ksmedia.data.Video;
import com.khoisang.ksmedia.data.Video.VideoListener;
import com.khoisang.ksmedia.ui.ActivityMain;
import com.khoisang.ksmedia.ui.extend.MyVideoViewKSMedia;

public class TimerSchedule {
	public interface ScheduleListener {
		public void scheduleStartPlayer(Schedule schedule, Video video);

		public void scheduleEndPlayer(Schedule schedule, Video video);

		public void scheduleStartDownload(Schedule schedule, Video video);

		public void scheduleStartApi();

		public void scheduleError(Exception ex);
	}

	protected static final String TAG = "Schedule";
	private final int API_INTERVAL_MILI_SECOND = 10 * 60 * 1000; // 10'

	private Timer mTimerGetApi = null;
	private Timer mTimerError = null;

	private Handler mHandlerTimerStartPlayer = null;
	private Handler mHandlerTimerEndPlayer = null;
	private Handler mHandlerTimerDownload = null;
	private Handler mHandlerTimerGetApi = null;
	private Handler mHandlerTimerError = null;

	private Message mMessageStartPlayer = null;
	private Message mMessageEndPlayer = null;
	private Message mMessageDownload = null;

	public TimerSchedule() {
		mMessageStartPlayer = new Message();
		mMessageEndPlayer = new Message();
		mMessageDownload = new Message();
	}

	private ScheduleListener mListener;

	public ScheduleListener getListener() {
		return mListener;
	}

	public void setListener(ScheduleListener mListener) {
		this.mListener = mListener;
	}

	public void handlerStartPlayer(final MyVideoViewKSMedia media, final Schedule schedule, long delay) {
		try {
			destroyHandlerTimerStartPlayer();
			mHandlerTimerStartPlayer = new Handler(new Handler.Callback() {
				@Override
				public boolean handleMessage(Message message) {
					try {
						if (schedule != null && schedule.getListVideo() != null && schedule.getListVideo().size() > 0) {
							media.play(schedule);
						} // End if
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
					return true;
				}
			});
			mHandlerTimerStartPlayer.sendMessageDelayed(Message.obtain(mMessageStartPlayer), delay);
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void handlerEndPlayer(final MyVideoViewKSMedia media, long delay) {
		try {
			destroyHandlerTimerEndPlayer();
			mHandlerTimerEndPlayer = new Handler(new Handler.Callback() {
				@Override
				public boolean handleMessage(Message message) {
					try {
						media.stop();
						if (getListener() != null)
							getListener().scheduleEndPlayer(media.getSchedule(), media.getVideo());
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
					return true;
				}
			});
			mHandlerTimerEndPlayer.sendMessageDelayed(Message.obtain(mMessageEndPlayer), delay);
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void handlerDownload(final Schedule schedule, final Video video, final VideoListener videoListener, final HttpDownloadManager downloadManager, int delay) {
		try {
			destroyHandlerTimerDownload();
			mHandlerTimerDownload = new Handler(new Handler.Callback() {
				@Override
				public boolean handleMessage(Message message) {
					try {
						video.download(downloadManager, schedule, videoListener);
						if (video != null) {
							if (getListener() != null)
								getListener().scheduleStartDownload(schedule, video);
						}
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
					return true;
				}
			});
			mHandlerTimerDownload.sendMessageDelayed(Message.obtain(mMessageDownload), delay);
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void handlerApiGetVideo(final Context context, final String tokenId, final ApiManager apiManager, final HttpHandler httpHandler, final Gson gson) {
		try {
			mTimerGetApi = new Timer();
			mHandlerTimerGetApi = new Handler(new Handler.Callback() {
				@Override
				public boolean handleMessage(Message msg) {
					try {
						InputGetVideo inputGetVideo = new InputGetVideo();
						inputGetVideo.timeStart = TimeStampUtil.dateToUnixTimeStamp(new Date());
						inputGetVideo.tokenID = tokenId;
						apiManager.call(APIName.GET_SCHEDULE, inputGetVideo, httpHandler, gson);
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
					return false;
				}
			});

			mTimerGetApi.scheduleAtFixedRate(new TimerTask() {
				@Override
				public void run() {
					try {
						mHandlerTimerGetApi.removeMessages(0);
						mHandlerTimerGetApi.sendEmptyMessage(0);
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
				}
			}, 10, API_INTERVAL_MILI_SECOND);
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void handlerApiError(final WeakReference<ActivityMain> activityMain, final ApiManager apiManager, final HttpHandler httpHandler, final Gson gson) {
		try {
			mTimerError = new Timer();
			mHandlerTimerError = new Handler(new Handler.Callback() {
				@Override
				public boolean handleMessage(Message msg) {
					try {
						if (activityMain != null && activityMain.get() != null) {
							String error = activityMain.get().getError();
							if (error != null && error.equalsIgnoreCase("") == false) {
								InputError inputError = new InputError();
								inputError.detailLog = error;
								inputError.tokenID = Storage.getTokenId(activityMain.get());
								apiManager.call(APIName.ERROR, inputError, httpHandler, gson);
							}
						}
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
					return false;
				}
			});

			mTimerError.scheduleAtFixedRate(new TimerTask() {
				@Override
				public void run() {
					try {
						mHandlerTimerError.removeMessages(0);
						mHandlerTimerError.sendEmptyMessage(0);
					} catch (Exception ex) {
						if (getListener() != null)
							getListener().scheduleError(ex);
					}
				}
			}, 10, API_INTERVAL_MILI_SECOND);
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroy() {
		try {
			destroyHandlerTimerStartPlayer();
			destroyHandlerTimerEndPlayer();
			destroyHandlerTimerDownload();
			destroyHandlerTimerGetAPI();
			destroyHandlerTimerError();
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroyHandlerTimerGetAPI() {
		try {
			if (mTimerGetApi != null) {
				mTimerGetApi.cancel();
				mTimerGetApi.purge();
				mTimerGetApi = null;
			}

			if (mHandlerTimerGetApi != null) {
				mHandlerTimerGetApi.removeCallbacksAndMessages(null);
			}
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroyHandlerTimerError() {
		try {
			if (mTimerError != null) {
				mTimerError.cancel();
				mTimerError.purge();
				mTimerError = null;
			}

			if (mHandlerTimerError != null) {
				mHandlerTimerError.removeCallbacksAndMessages(null);
			}
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroyHandlerTimerStartPlayer() {
		try {
			if (mHandlerTimerStartPlayer != null) {
				mHandlerTimerStartPlayer.removeCallbacksAndMessages(null);
			}
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroyHandlerTimerEndPlayer() {
		try {
			if (mHandlerTimerEndPlayer != null) {
				mHandlerTimerEndPlayer.removeCallbacksAndMessages(null);
			}
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}

	public void destroyHandlerTimerDownload() {
		try {
			if (mHandlerTimerDownload != null) {
				mHandlerTimerDownload.removeCallbacksAndMessages(null);
			}
		} catch (Exception ex) {
			if (getListener() != null)
				getListener().scheduleError(ex);
		}
	}
}
