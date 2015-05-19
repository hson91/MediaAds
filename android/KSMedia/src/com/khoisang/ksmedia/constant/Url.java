package com.khoisang.ksmedia.constant;

import android.net.Uri;

public class Url {

	private static String SCHEMA = "http";
	private static String SERVER_PATH = "tongkho.info/mediasolution";

	public static Uri.Builder getServerPath() {
		Uri.Builder builder = new Uri.Builder();
		builder.scheme(Url.SCHEMA);
		builder.encodedAuthority(Url.SERVER_PATH);
		return builder;
	}

	public static String API_GETTING_STARTED_PATH = "api/gettingStarted";
	public static String API_GET_VIDEO_PATH = "api/getSchedule";
	public static String API_ERROR_PATH = "api/setLog/error";

}
