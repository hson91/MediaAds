package com.khoisang.ksmedia.ui;

import java.io.File;
import java.lang.Thread.UncaughtExceptionHandler;
import java.lang.ref.WeakReference;
import java.lang.reflect.Type;
import java.net.SocketException;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

import org.apache.commons.lang3.exception.ExceptionUtils;

import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.PixelFormat;
import android.location.Location;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings.Secure;
import android.telephony.TelephonyManager;
import android.view.Gravity;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.RelativeLayout;
import android.widget.RelativeLayout.LayoutParams;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.khoisang.khoisanglibary.date.TimeStampUtil;
import com.khoisang.khoisanglibary.dev.DebugLog;
import com.khoisang.khoisanglibary.dev.DebugLog.DebugLogListerner;
import com.khoisang.khoisanglibary.dev.FileWriter;
import com.khoisang.khoisanglibary.network.HttpDownloadManager;
import com.khoisang.khoisanglibary.network.HttpDownloadManager.AsyntaskDownloadHttp;
import com.khoisang.khoisanglibary.network.HttpHandler;
import com.khoisang.khoisanglibary.network.HttpResult;
import com.khoisang.khoisanglibary.os.AsyncTask.Status;
import com.khoisang.khoisanglibary.ui.ActionEvent;
import com.khoisang.khoisanglibary.ui.activity.BaseActivity;
import com.khoisang.khoisanglibary.util.NetwordUtil;
import com.khoisang.khoisanglibary.util.ServiceUtil;
import com.khoisang.khoisanglibary.util.StorageUtil;
import com.khoisang.khoisanglibary.util.WriterLog;
import com.khoisang.khoisanglibary.util.WriterLog.LogType;
import com.khoisang.ksmedia.R;
import com.khoisang.ksmedia.api.ApiManager;
import com.khoisang.ksmedia.api.structure.InputGettingStarted;
import com.khoisang.ksmedia.api.structure.OutputGetSchedule;
import com.khoisang.ksmedia.api.structure.OutputGettingStarted;
import com.khoisang.ksmedia.constant.APIName;
import com.khoisang.ksmedia.constant.ApiCode;
import com.khoisang.ksmedia.data.Schedule;
import com.khoisang.ksmedia.data.Video;
import com.khoisang.ksmedia.data.Video.FileState;
import com.khoisang.ksmedia.data.Video.VideoListener;
import com.khoisang.ksmedia.ui.extend.ConnectivityChangeReceiver;
import com.khoisang.ksmedia.ui.extend.CustomViewGroup;
import com.khoisang.ksmedia.ui.extend.MyLocationManager;
import com.khoisang.ksmedia.ui.extend.MyLocationManager.DelegateLocation;
import com.khoisang.ksmedia.ui.extend.MyVideoViewKSMedia;
import com.khoisang.ksmedia.ui.extend.MyVideoViewKSMedia.MediaPlayerListener;
import com.khoisang.ksmedia.ultil.Storage;
import com.khoisang.ksmedia.ultil.TimerSchedule;
import com.khoisang.ksmedia.ultil.TimerSchedule.ScheduleListener;

public class ActivityMain extends BaseActivity implements HttpHandler, UncaughtExceptionHandler, DebugLogListerner, MediaPlayerListener, ScheduleListener, VideoListener, DelegateLocation {

	public enum RunMode {
		INIT, OFFLINE, ONLINE
	}

	private final int SCHEDULE_DELAY_DOWNLOAD_MILI_SECOND = 1000;
	private final int SCHEDULE_DELAY_START_MILI_SECOND = 1000;
	private RunMode mRunningMode = RunMode.INIT;
	// UI
	private ViewGroup _root;

	private ApiManager mApiManager = null;
	private HttpDownloadManager mDownloadManager = null;
	private FileWriter mLogError = null;
	private UncaughtExceptionHandler mUncaugheException = null;
	private MyVideoViewKSMedia mMediaPlayer = null;
	private Schedule mCurrentSchedule = null;
	private List<Schedule> mListSchedule = null;
	private TimerSchedule mTimerSchedule = null;
	private WriterLog mWriterLog = null;
	private Gson mGson = null;
	private ConnectivityChangeReceiver mConnectivityChangeReceiver;
	private MyLocationManager mMyLocationManager;

	private synchronized List<Schedule> getListSchedule() {
		if (mListSchedule == null)
			mListSchedule = new ArrayList<Schedule>();
		return mListSchedule;
	}

	@Override
	protected int getLayoutID() {
		return R.layout.activity_main;
	}

	@Override
	public void handleEvent(ActionEvent actionEvent) {
	}

	@Override
	protected void beforeSetLayoutID(Bundle savedInstanceState) {
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
		getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
	}

	@Override
	protected void afterSetLayoutID(Bundle savedInstanceState) {
		WindowManager manager = ((WindowManager) getApplicationContext().getSystemService(Context.WINDOW_SERVICE));

		WindowManager.LayoutParams localLayoutParams = new WindowManager.LayoutParams();
		localLayoutParams.type = WindowManager.LayoutParams.TYPE_SYSTEM_ERROR;
		localLayoutParams.gravity = Gravity.TOP;
		localLayoutParams.flags = WindowManager.LayoutParams.FLAG_NOT_FOCUSABLE | WindowManager.LayoutParams.FLAG_NOT_TOUCH_MODAL | WindowManager.LayoutParams.FLAG_LAYOUT_IN_SCREEN;

		localLayoutParams.width = WindowManager.LayoutParams.MATCH_PARENT;
		localLayoutParams.height = (int) (50 * getResources().getDisplayMetrics().scaledDensity);
		localLayoutParams.format = PixelFormat.TRANSPARENT;

		CustomViewGroup view = new CustomViewGroup(this);
		manager.addView(view, localLayoutParams);

		DebugLog.DEBUG = true;
		DebugLog.setListerner(this);

		mTimerSchedule = new TimerSchedule();
		mTimerSchedule.setListener(this);

		mGson = new Gson();

		mApiManager = new ApiManager();
		mDownloadManager = new HttpDownloadManager();

		mLogError = new FileWriter(getApplication(), getString(R.string.error_file_name));

		File folder = StorageUtil.getDiskCacheDir(this, "log");
		folder.mkdirs();
		mWriterLog = WriterLog.getInstance(new File(folder, "error.txt"));

		mUncaugheException = Thread.getDefaultUncaughtExceptionHandler();
		Thread.setDefaultUncaughtExceptionHandler(this);

		mMyLocationManager = new MyLocationManager(this);
		mMyLocationManager.setDelegate(this);
		mMyLocationManager.init();

		mMediaPlayer = new MyVideoViewKSMedia(this);
		mMediaPlayer.setListener(this);

		// Connection change
		mConnectivityChangeReceiver = new ConnectivityChangeReceiver(this);
		IntentFilter filter = new IntentFilter();
		filter.addAction("android.net.wifi.WIFI_STATE_CHANGED");
		filter.addAction("android.net.conn.CONNECTIVITY_CHANGE");
		registerReceiver(mConnectivityChangeReceiver, filter);

		if (StorageUtil.checkExternalStorageState(this) == false) {
			String error_usb_not_found = getString(R.string.error_usb_not_found);
			handleError(new Exception(error_usb_not_found));
			return;
		}

		if (ServiceUtil.isRunning(getApplicationContext(), ServiceCheckActivity.class.getName()) == false)
			startService(new Intent(this, ServiceCheckActivity.class));

		if (NetwordUtil.isNetworkAvailable(this) == false) {
			runOfflineMode();
		} else {
			runOnlineMode();
		}
	}

	public synchronized void runOfflineMode() {
		if (mRunningMode == RunMode.INIT || mRunningMode == RunMode.ONLINE) {
			mRunningMode = RunMode.OFFLINE;
			//
			mTimerSchedule.destroy();
			String json = Storage.getSchdule(getApplicationContext());
			if (json.equalsIgnoreCase("") == false) { // Not found
				ArrayList<Schedule> listSchedule = null;
				try {
					Type listType = new TypeToken<ArrayList<Schedule>>() {
					}.getType();
					listSchedule = mGson.fromJson(json, listType);
				} catch (Exception ex) {
					// Ignore
				}
				//
				if (listSchedule != null && listSchedule.size() > 0) {
					long systemTimeStamp = TimeStampUtil.getCurrentSystemTimeStamp();
					setListSchedule(systemTimeStamp, listSchedule, false);
				} // End if
			} // End if
		} // End if
	}

	public synchronized void runOnlineMode() {
		if (mRunningMode == RunMode.INIT || mRunningMode == RunMode.OFFLINE) {
			mRunningMode = RunMode.ONLINE;
			//
			callGettingStartedApi();
		}
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}

	@Override
	protected void onRestart() {
		super.onRestart();
	}

	@Override
	protected void onStart() {
		super.onStart();
	}

	@Override
	protected void onResume() {
		super.onResume();

		RelativeLayout.LayoutParams layoutParams = new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT);
		layoutParams.addRule(RelativeLayout.ALIGN_PARENT_LEFT);
		layoutParams.addRule(RelativeLayout.ALIGN_PARENT_TOP);
		layoutParams.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
		layoutParams.addRule(RelativeLayout.ALIGN_PARENT_BOTTOM);

		_root.addView(mMediaPlayer, layoutParams);
		mMediaPlayer.resume();
	}

	@Override
	protected void onPause() {
		super.onPause();

		mMediaPlayer.stop();
		_root.removeView(mMediaPlayer);
	}

	@Override
	protected void onStop() {
		super.onStop();
	}

	@Override
	protected void onDestroy() {
		unregisterReceiver(mConnectivityChangeReceiver);
		if (mMediaPlayer != null)
			mMediaPlayer.stop();

		if (mTimerSchedule != null)
			mTimerSchedule.destroy();

		super.onDestroy();
	}

	private synchronized void setListSchedule(long systemTimeStamp, List<Schedule> listSchedule, boolean onlineMode) {
		if (onlineMode == true) {
			Schedule.copy(getApplicationContext(), listSchedule, getListSchedule());
		} else {
			if (listSchedule != null && listSchedule.size() > 0) {
				getListSchedule().addAll(listSchedule);
			}
		}

		if (getListSchedule().size() > 0) {
			Schedule schedule = getListSchedule().get(0);
			if (schedule != null) {
				if (onlineMode == true) {
					checkTimerDownload(schedule);
					Storage.saveSchduleIntoPrivateStorage(getApplicationContext(), getListSchedule(), mGson);
				} else {
					schedule.timeEnd = ((long) Integer.MAX_VALUE) * 1000;
				}
				checkTimerPlayer(systemTimeStamp, schedule, onlineMode);
			} // End if
		} // End if
	}

	private void checkTimerPlayer(long systemTimeStamp, Schedule schedule, boolean onlineMode) {
		if (schedule != null) {
			if (mCurrentSchedule == null || mCurrentSchedule.scheduleID != schedule.scheduleID || mCurrentSchedule.timeStart != schedule.timeStart || mCurrentSchedule.timeEnd != schedule.timeEnd || mCurrentSchedule.getListVideo().size() != schedule.getListVideo().size()) {
				if (mCurrentSchedule == null)
					mCurrentSchedule = new Schedule();
				mCurrentSchedule.copy(schedule);
				setTimerPlayer(systemTimeStamp, mCurrentSchedule, onlineMode);
			}
		}
	}

	private void checkTimerDownload(Schedule schedule) {
		if (schedule != null) {
			List<Video> listVideo = schedule.getListVideo();
			List<Video> listVideoUnvailable = new ArrayList<Video>();
			for (int i = 0; listVideo != null && i < listVideo.size(); i++) {
				Video tempVideo = listVideo.get(i);
				if (tempVideo != null && tempVideo.getFileState() == FileState.NONEXIST) {
					listVideoUnvailable.add(tempVideo);
				}
			} // End for

			if (listVideoUnvailable.size() > 0) {
				Random random = new Random();
				int index = random.nextInt(listVideoUnvailable.size());
				Video video = listVideoUnvailable.get(index);
				AsyntaskDownloadHttp asyntaskHttpDownload = mDownloadManager.getLastAsyntask();
				if (asyntaskHttpDownload == null || asyntaskHttpDownload.getStatus() == Status.FINISHED)
					setTimerDownload(schedule, video, SCHEDULE_DELAY_DOWNLOAD_MILI_SECOND);
			}
		}
	}

	private void setTimerPlayer(long systemTimeStamp, Schedule schedule, boolean onlineMode) {
		long delayStart = 0;
		if (systemTimeStamp > schedule.timeStart)
			delayStart = SCHEDULE_DELAY_START_MILI_SECOND;
		else
			delayStart = schedule.timeStart - systemTimeStamp;

		mTimerSchedule.handlerStartPlayer(mMediaPlayer, schedule, delayStart);
		mTimerSchedule.handlerEndPlayer(mMediaPlayer, schedule.timeEnd - systemTimeStamp);
	}

	private void setTimerDownload(Schedule schedule, Video video, int delay) {
		mTimerSchedule.handlerDownload(schedule, video, this, mDownloadManager, delay);
	}

	private void callGettingStartedApi() {
		try {
			InputGettingStarted inputGettingStarted = new InputGettingStarted();

			String deviceId = null;
			TelephonyManager telephonyManager = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
			deviceId = telephonyManager.getDeviceId();
			if (deviceId == null || deviceId.equalsIgnoreCase("") == true)
				deviceId = Secure.getString(getApplicationContext().getContentResolver(), Secure.ANDROID_ID);
			inputGettingStarted.tokenID = Storage.getTokenId(getApplicationContext());
			inputGettingStarted.deviceID = deviceId;

			inputGettingStarted.deviceName = Build.MODEL;
			inputGettingStarted.deviceProducers = Build.MANUFACTURER;
			inputGettingStarted.deviceOS = 0;
			inputGettingStarted.versionOS = String.valueOf(Build.VERSION.SDK_INT);
			inputGettingStarted.coordinatesX = Storage.getLocationX(getApplicationContext());
			inputGettingStarted.coordinatesY = Storage.getLocationY(getApplicationContext());

			WifiManager wifiManager = (WifiManager) getSystemService(Context.WIFI_SERVICE);
			WifiInfo wifiInfo = wifiManager.getConnectionInfo();
			inputGettingStarted.macAddress = wifiInfo.getMacAddress();

			String ipAddress = null;
			try {
				ipAddress = NetwordUtil.getIPAddress(true);
			} catch (SocketException e) {
				ipAddress = "";
			}
			inputGettingStarted.ipAddress = ipAddress;

			inputGettingStarted.versionApp = String.valueOf(Build.VERSION.RELEASE);
			inputGettingStarted.deviceWidth = getScreenWidth();
			inputGettingStarted.deviceHeight = getScreenHeight();

			String error = "";
			inputGettingStarted.deviceErrorsLog = error;
			inputGettingStarted.typeSizeVideo = 0;
			inputGettingStarted.status = 1;

			mApiManager.call(APIName.GETTING_STARTED, inputGettingStarted, this, mGson);
		} catch (Exception ex) {
			handleError(ex);
		}
	}

	// <-- Delegate API
	@Override
	public void prePrequest(int ID, int Name, Object holder) {
	}

	@Override
	public void handleException(int ID, int Name, Exception ex, Object holder) {
		handleError(ex);
	}

	@Override
	public void handleCancel(int ID, int Name, Object holder) {
	}

	@Override
	public void handleResult(int ID, int Name, HttpResult httpResult, String bodyString, Object holder) {
		try {
			long systemTimeStamp = TimeStampUtil.getCurrentSystemTimeStamp();
			/*long unixTimeStamp = systemTimeStamp / 1000l;*/

			switch (Name) {
			case APIName.GETTING_STARTED:
				OutputGettingStarted outputGettingStarted = mGson.fromJson(bodyString, OutputGettingStarted.class);
				if (outputGettingStarted != null && outputGettingStarted.status == ApiCode.SUCCESSFUL) {
					if (outputGettingStarted.data.device != null) {
						String tokenId = Storage.getTokenId(getApplicationContext());
						if (tokenId == null || tokenId.trim().equalsIgnoreCase("") == true) {
							Storage.saveTokenId(getApplicationContext(), outputGettingStarted.data.device.deviceToken);
							tokenId = Storage.getTokenId(getApplicationContext());
						}

						showToast("Successful...", false);
						mTimerSchedule.handlerApiGetVideo(getApplicationContext(), tokenId, mApiManager, ActivityMain.this, mGson);
						mTimerSchedule.handlerApiError(new WeakReference<ActivityMain>(this), mApiManager, ActivityMain.this, mGson);
					}
				} else {
					runOfflineMode();
				}
				break;
			case APIName.GET_SCHEDULE:
				OutputGetSchedule outputGetVideo = mGson.fromJson(bodyString, OutputGetSchedule.class);
				if (outputGetVideo != null && outputGetVideo.status == ApiCode.SUCCESSFUL && outputGetVideo.data != null && outputGetVideo.data.schedule != null && outputGetVideo.data.schedule.size() > 0) {
					showToast("Schedule: " + String.valueOf(outputGetVideo.data.schedule.size()), false);
					setListSchedule(systemTimeStamp, outputGetVideo.data.schedule, true);
				} else {
					runOfflineMode();
				}
				break;
			default:
				break;
			}
		} catch (Exception ex) {
			handleError(ex);
		}
	}

	private synchronized void handleError(final Exception ex) {
		if (ex != null) {
			try {
				String content = ExceptionUtils.getStackTrace(ex);
				writeLog(LogType.Error, content);
			} catch (Exception e) {
				// Ignore
			}
		} // End if
	}

	private synchronized void writeLog(LogType logType, final String content) {
		try {
			mWriterLog.write(logType, content);
			if (logType == LogType.Error) {
				mLogError.write(content);
				mLogError.write("\n");
				//
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						//showToast(content, false);
					}
				});
			}
		} catch (Exception ex) {
			// Ignore
		}
	}

	public String getError() {
		if (mLogError != null)
			try {
				return mLogError.get(true);
			} catch (Exception e) {
				// Ignore
			}
		return "";
	}

	@Override
	public void uncaughtException(Thread thread, Throwable ex) {
		handleError((Exception) ex);
		mUncaugheException.uncaughtException(thread, ex);
	}

	@Override
	public void debugLogHandlerError(Exception ex) {
	}

	@Override
	public void playerOnError(Exception ex, int what, int extra, Schedule schedule, Video video) {
		try {
			if (video != null) {
				video.delete();
			}
			handleError(ex);
			if (NetwordUtil.isNetworkAvailable(getApplicationContext()) == true)
				checkTimerDownload(schedule);
		} catch (Exception newEx) {
			// Ignore
		}
	}

	@Override
	public void playerOnStart() {
		String content = "playerOnStart";
		writeLog(LogType.Infor, content);
	}

	@Override
	public void playerOnStop() {
		String content = "playerOnStop";
		writeLog(LogType.Infor, content);
	}

	@Override
	public void scheduleStartPlayer(Schedule schedule, Video video) {
		String content = "scheduleStartPlayer: " + video.videoID;
		writeLog(LogType.Infor, content);
	}

	@Override
	public void scheduleEndPlayer(Schedule schedule, Video video) {
		String content = "scheduleEndPlayer: " + video.videoID;
		writeLog(LogType.Infor, content);

		getListSchedule().remove(schedule);
		if (getListSchedule().size() > 0)
			checkTimerPlayer(TimeStampUtil.getCurrentSystemTimeStamp(), getListSchedule().get(0), false);
	}

	@Override
	public void scheduleStartDownload(Schedule schedule, Video video) {
		String content = "scheduleStartDownload: " + video.videoID + " - " + video.getFileLocal().getAbsolutePath();
		writeLog(LogType.Infor, content);
	}

	@Override
	public void scheduleStartApi() {
		String content = "scheduleStartApi";
		writeLog(LogType.Infor, content);
	}

	@Override
	public void scheduleError(Exception ex) {
		try {
			handleError(ex);
		} catch (Exception newEx) {
			// Ignore
		}
	}

	@Override
	public void downloadFileException(Exception ex, Schedule schedule, Video video) {
		try {
			if (NetwordUtil.isNetworkAvailable(getApplicationContext()) == true)
				checkTimerDownload(schedule);
			handleError(ex);
		} catch (Exception newEx) {
			// Ignore
		}
	}

	@Override
	public void downloadFileComplete(final Schedule schedule, Video video) {
		runOnUiThread(new Runnable() {
			@Override
			public void run() {
				long timeStamp = TimeStampUtil.getCurrentSystemTimeStamp();
				checkTimerDownload(schedule);
				if (mMediaPlayer.isPlaying() == false)
					setTimerPlayer(timeStamp, schedule, true);
			} // End run
		}); // End new
	}

	@Override
	public void getLocation(Location location) {
		if (location != null) {
			Storage.saveLocationX(getApplicationContext(), String.valueOf(location.getLatitude()));
			Storage.saveLocationY(getApplicationContext(), String.valueOf(location.getLongitude()));
		}
	}
}
