package com.khoisang.ksmedia.ui;

import android.app.Service;
import android.content.Intent;
import android.os.IBinder;

public class ServiceBootComplete extends Service {

	@Override
	public IBinder onBind(Intent intent) {
		return null;
	}

	@Override
	public void onCreate() {
		Intent intent = new Intent(this, ActivityMain.class);
		intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
		getApplication().startActivity(intent);
		startActivity(intent);
	}
}
