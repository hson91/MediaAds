package com.khoisang.ksmedia.ui.extend;

import java.lang.ref.WeakReference;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

import com.khoisang.khoisanglibary.util.NetwordUtil;
import com.khoisang.ksmedia.ui.ActivityMain;

public class ConnectivityChangeReceiver extends BroadcastReceiver {

	private WeakReference<ActivityMain> activityMain;

	public ConnectivityChangeReceiver(ActivityMain activityMain) {
		super();
		this.activityMain = new WeakReference<ActivityMain>(activityMain);
	}

	@Override
	public void onReceive(Context context, Intent intent) {
		if (activityMain != null && activityMain.get() != null) {
			if (NetwordUtil.isNetworkAvailable(activityMain.get()) == true)
				activityMain.get().runOnlineMode();
			else
				activityMain.get().runOfflineMode();
		} // End if
	}
}
