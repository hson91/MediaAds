package com.khoisang.ksmedia.ui;

import com.khoisang.khoisanglibary.util.ServiceUtil;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

public class BroadcastReceiverBootComplete extends BroadcastReceiver {

	@Override
	public void onReceive(Context context, Intent intent) {
		if (ServiceUtil.isRunning(context, ServiceBootComplete.class.getName()) == false) {
			Intent service = new Intent(context, ServiceBootComplete.class);
			context.startService(service);
		} // End if
	}
}
