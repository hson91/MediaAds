package com.khoisang.ksmedia.api;

import org.apache.http.entity.ContentType;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntityBuilder;
import org.apache.http.entity.mime.content.StringBody;

import android.net.Uri;

import com.google.gson.Gson;
import com.khoisang.khoisanglibary.network.HttpHandler;
import com.khoisang.khoisanglibary.network.HttpManager;
import com.khoisang.ksmedia.api.structure.InputBase;
import com.khoisang.ksmedia.api.structure.InputError;
import com.khoisang.ksmedia.api.structure.InputGetVideo;
import com.khoisang.ksmedia.api.structure.InputGettingStarted;
import com.khoisang.ksmedia.constant.APIName;
import com.khoisang.ksmedia.constant.ApiParameters;
import com.khoisang.ksmedia.constant.Url;

public class ApiManager {
	private HttpManager mHttpManager;

	public ApiManager() {
		mHttpManager = new HttpManager();
	}

	public int call(int apiName, InputBase input, HttpHandler httpHandler, Object holder) {
		int id = -1;
		switch (apiName) {
		case APIName.GETTING_STARTED:
			id = gettingStarted(apiName, (InputGettingStarted) input, httpHandler, holder);
			break;
		case APIName.GET_SCHEDULE:
			id = getVideo(apiName, (InputGetVideo) input, httpHandler, holder);
			break;
		case APIName.ERROR:
			id = error(apiName, (InputError) input, httpHandler, holder);
			break;
		default:
			break;
		}

		return id;
	}

	public int gettingStarted(int apiName, InputGettingStarted inputGettingStarted, HttpHandler httpHandler, Object holder) {
		Gson gson = (Gson) holder;
		String json = gson.toJson(inputGettingStarted);

		MultipartEntityBuilder multipartEntityBuilder = MultipartEntityBuilder.create();
		multipartEntityBuilder.setMode(HttpMultipartMode.BROWSER_COMPATIBLE);
		multipartEntityBuilder.addPart(ApiParameters.BODY_KEY, new StringBody(json, ContentType.APPLICATION_FORM_URLENCODED));

		Uri.Builder builder = Url.getServerPath();
		builder.appendEncodedPath(Url.API_GETTING_STARTED_PATH);
		return mHttpManager.post(apiName, holder, builder.build(), httpHandler, null, multipartEntityBuilder);
	}

	public int getVideo(int apiName, InputGetVideo inputGetVideo, HttpHandler httpHandler, Object holder) {
		Gson gson = (Gson) holder;
		String json = gson.toJson(inputGetVideo);

		MultipartEntityBuilder multipartEntityBuilder = MultipartEntityBuilder.create();
		multipartEntityBuilder.setMode(HttpMultipartMode.BROWSER_COMPATIBLE);
		multipartEntityBuilder.addPart(ApiParameters.BODY_KEY, new StringBody(json, ContentType.APPLICATION_FORM_URLENCODED));

		Uri.Builder builder = Url.getServerPath();
		builder.appendEncodedPath(Url.API_GET_VIDEO_PATH);

		return mHttpManager.post(apiName, holder, builder.build(), httpHandler, null, multipartEntityBuilder);
	}

	public int error(int apiName, InputError inputError, HttpHandler httpHandler, Object holder) {
		Gson gson = (Gson) holder;
		String json = gson.toJson(inputError);

		MultipartEntityBuilder multipartEntityBuilder = MultipartEntityBuilder.create();
		multipartEntityBuilder.setMode(HttpMultipartMode.BROWSER_COMPATIBLE);
		multipartEntityBuilder.addPart(ApiParameters.BODY_KEY, new StringBody(json, ContentType.APPLICATION_FORM_URLENCODED));

		Uri.Builder builder = Url.getServerPath();
		builder.appendEncodedPath(Url.API_ERROR_PATH);

		return mHttpManager.post(apiName, holder, builder.build(), httpHandler, null, multipartEntityBuilder);
	}
}
