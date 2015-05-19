package com.khoisang.ksmedia.ultil;

import java.util.List;

import android.content.Context;
import android.content.SharedPreferences;

import com.google.gson.Gson;
import com.khoisang.ksmedia.data.Schedule;

public class Storage {
	private static final String SHARE_PREFERENCES_NAME = "media_solution";
	private static final String SHARE_PREFERENCES_SCHEDULE = "schedule";
	private static final String SHARE_PREFERENCES_TOKEN_ID = "token_id";
	private static final String SHARE_PREFERENCES_LOCATION_X = "location_x";
	private static final String SHARE_PREFERENCES_LOCATION_Y = "location_y";

	public static void saveSchduleIntoPrivateStorage(Context context, List<Schedule> listSchedule, Gson gson) {
		SharedPreferences.Editor editorSharedPreference = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE).edit();
		String json = gson.toJson(listSchedule);
		editorSharedPreference.putString(SHARE_PREFERENCES_SCHEDULE, json);
		editorSharedPreference.commit();
	}

	public static String getSchdule(Context context) {
		SharedPreferences sharedPreferences = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.getString(SHARE_PREFERENCES_SCHEDULE, "");
	}

	public static void saveTokenId(Context context, String tokenID) {
		SharedPreferences.Editor editorSharedPreference = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE).edit();
		editorSharedPreference.putString(SHARE_PREFERENCES_TOKEN_ID, tokenID);
		editorSharedPreference.commit();
	}

	public static String getTokenId(Context context) {
		SharedPreferences sharedPreferences = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.getString(SHARE_PREFERENCES_TOKEN_ID, "");
	}

	public static void saveLocationX(Context context, String locationX) {
		SharedPreferences.Editor editorSharedPreference = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE).edit();
		editorSharedPreference.putString(SHARE_PREFERENCES_LOCATION_X, locationX);
		editorSharedPreference.commit();
	}

	public static String getLocationX(Context context) {
		SharedPreferences sharedPreferences = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.getString(SHARE_PREFERENCES_LOCATION_X, "");
	}

	public static void saveLocationY(Context context, String locationY) {
		SharedPreferences.Editor editorSharedPreference = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE).edit();
		editorSharedPreference.putString(SHARE_PREFERENCES_LOCATION_Y, locationY);
		editorSharedPreference.commit();
	}

	public static String getLocationY(Context context) {
		SharedPreferences sharedPreferences = context.getSharedPreferences(SHARE_PREFERENCES_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.getString(SHARE_PREFERENCES_LOCATION_Y, "");
	}
}
