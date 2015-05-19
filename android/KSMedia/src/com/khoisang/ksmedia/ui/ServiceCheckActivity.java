package com.khoisang.ksmedia.ui;

import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import android.app.ActivityManager;
import android.app.Service;
import android.content.ComponentName;
import android.content.Intent;
import android.os.IBinder;

public class ServiceCheckActivity extends Service {
	protected static final String TAG = "ServiceCheckActivity";
	private Timer mTimer = null;

	@Override
	public IBinder onBind(Intent intent) {
		return null;
	}

	@Override
	public int onStartCommand(Intent intent, int flags, int startId) {
		mTimer = new Timer();
		mTimer.scheduleAtFixedRate(new TimerTask() {
			@Override
			public void run() {
				if (isForeground(ServiceCheckActivity.this.getApplicationContext().getPackageName()) == false) {
					Intent intent = new Intent(getApplicationContext(), ActivityMain.class);
					intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
					getApplication().startActivity(intent);
				}
			}
		}, 10000, 5000);
		return 1;
	}

	@Override
	public void onDestroy() {
		super.onDestroy();
	}

	@SuppressWarnings("deprecation")
	public boolean isForeground(String myPackage) {
		ActivityManager manager = (ActivityManager) getSystemService(ACTIVITY_SERVICE);
		List<ActivityManager.RunningTaskInfo> runningTaskInfo = manager.getRunningTasks(1);
		ComponentName componentInfo = runningTaskInfo.get(0).topActivity;
		if (componentInfo.getPackageName().equalsIgnoreCase(myPackage))
			return true;
		return false;
	}
}
