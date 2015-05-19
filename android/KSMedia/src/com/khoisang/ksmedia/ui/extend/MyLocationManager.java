package com.khoisang.ksmedia.ui.extend;

import java.lang.ref.WeakReference;

import android.app.Activity;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;

import com.khoisang.ksmedia.ui.ActivityMain;

public class MyLocationManager implements LocationListener {
	public interface DelegateLocation {
		public void getLocation(Location location);
	}

	private WeakReference<ActivityMain> mActivityMain;
	// location
	private Location mLocation = null;
	private DelegateLocation mDelegate;
	private Object mLock = new Object();

	public void setDelegate(DelegateLocation delegate) {
		mDelegate = delegate;
	}

	public MyLocationManager(ActivityMain activityMain) {
		mActivityMain = new WeakReference<ActivityMain>(activityMain);
	}

	public void init() {
		LocationManager locationManager = (LocationManager) mActivityMain.get().getSystemService(Activity.LOCATION_SERVICE);
		locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 1000, 10, this);
		Location location = locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);

		if (location != null && mLocation == null) {
			synchronized (mLock) {
				mLocation = location;
				if (mDelegate != null) {
					mDelegate.getLocation(mLocation);
				}
			} // End sync
		}
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
	}

	@Override
	public void onLocationChanged(Location location) {
		synchronized (mLock) {
			if (location != null && mLocation == null) {
				mLocation = location;
				if (mDelegate != null) {
					mDelegate.getLocation(mLocation);
				}
			}
		} // End sync
	}

	@Override
	public void onProviderEnabled(String provider) {

	}

	@Override
	public void onProviderDisabled(String provider) {

	}
}
