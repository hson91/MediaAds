package com.khoisang.ksmedia.ui.extend;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

import android.content.Context;
import android.media.MediaPlayer;
import android.media.MediaPlayer.OnBufferingUpdateListener;
import android.media.MediaPlayer.OnCompletionListener;
import android.media.MediaPlayer.OnErrorListener;
import android.media.MediaPlayer.OnInfoListener;
import android.media.MediaPlayer.OnPreparedListener;
import android.media.MediaPlayer.OnSeekCompleteListener;
import android.media.MediaPlayer.OnVideoSizeChangedListener;
import android.os.Handler;
import android.util.AttributeSet;
import android.view.SurfaceHolder;
import android.view.SurfaceHolder.Callback;
import android.view.SurfaceView;

import com.khoisang.ksmedia.data.Schedule;
import com.khoisang.ksmedia.data.Video;
import com.khoisang.ksmedia.data.Video.FileState;

public class MyVideoViewKSMedia extends SurfaceView implements OnBufferingUpdateListener, OnCompletionListener, OnErrorListener, OnInfoListener, OnPreparedListener, OnSeekCompleteListener, OnVideoSizeChangedListener {
	public enum StatePlayer {
		PRE_SETUP_HOLDER, SETUP_HOLDER, PREPARE, PLAYING, STOPPED, NONE
	}

	public enum StateSurfaceView {
		DESTROYED, CREATED, CHANGED, NONE
	}

	public interface MediaPlayerListener {
		void playerOnError(Exception ex, int what, int extra, Schedule schedule, Video video);

		void playerOnStart();

		void playerOnStop();
	}

	public Video getVideo() {
		if (mVideo == null)
			mVideo = new Video();
		return mVideo;
	}

	private void setVideo(Video mVideo) {
		this.mVideo = mVideo;
	}

	public MyVideoViewKSMedia(Context context) {
		super(context);
		init();
	}

	public MyVideoViewKSMedia(Context context, AttributeSet attributes) {
		super(context, attributes);
		init();
	}

	private void init() {
		setStatePlayer(StatePlayer.NONE);
		setStateSurfaceView(StateSurfaceView.NONE);

		SurfaceHolder surfaceHolder = getHolder();
		surfaceHolder.addCallback(new Callback() {
			@Override
			public void surfaceDestroyed(SurfaceHolder holder) {
				setStateSurfaceView(StateSurfaceView.DESTROYED);
			}

			@Override
			public void surfaceCreated(SurfaceHolder holder) {
				setStateSurfaceView(StateSurfaceView.CREATED);
				try {
					if (getStatePlayer() == StatePlayer.PRE_SETUP_HOLDER)
						prePlay(holder);
				} catch (IllegalArgumentException | SecurityException | IllegalStateException ex) {
					listenerError(ex, 0, 0);
				}
			}

			@Override
			public void surfaceChanged(SurfaceHolder holder, int format, int width, int height) {
				setStateSurfaceView(StateSurfaceView.CHANGED);
			}
		});
	}

	private MediaPlayer mPlayer;
	private StatePlayer mStatePlayer;
	private StateSurfaceView mStateSurfaceView;
	private MediaPlayerListener mListener;
	private boolean mErrorPlaying;
	private Schedule mSchedule;
	private Video mVideo;
	private Handler mHandler = new Handler();

	public Schedule getSchedule() {
		return mSchedule;
	}

	public void setSchedule(Schedule video) {
		mSchedule = video;
	}

	public MediaPlayerListener getListener() {
		return mListener;
	}

	public void setListener(MediaPlayerListener listener) {
		this.mListener = listener;
	}

	public StatePlayer getStatePlayer() {
		return mStatePlayer;
	}

	private void setStatePlayer(StatePlayer mState) {
		this.mStatePlayer = mState;
	}

	public StateSurfaceView getStateSurfaceView() {
		return mStateSurfaceView;
	}

	private void setStateSurfaceView(StateSurfaceView stateSurfaceView) {
		this.mStateSurfaceView = stateSurfaceView;
	}

	public void play(Schedule schedule) {
		play(schedule, false);
	}

	public void play(Schedule schedule, boolean looping) {
		play(schedule, looping, 0);
	}

	public void play(Schedule schedule, boolean looping, int position) {
		try {
			if (schedule == null)
				throw new Exception("Schedule is null");

			setSchedule(schedule);

			if (getStateSurfaceView() == StateSurfaceView.CREATED || getStateSurfaceView() == StateSurfaceView.CHANGED) {
				prePlay(getHolder());
			} else {
				setStatePlayer(StatePlayer.PRE_SETUP_HOLDER);
			}
		} catch (Exception ex) {
			listenerError(ex, 0, 0);
		}
	}

	private void prePlay(SurfaceHolder holder) {
		String url = null;
		try {
			setVideo(null);
			//
			if (getSchedule() != null && getSchedule().getListVideo() != null && getSchedule().getListVideo().size() > 0) {
				List<Video> listVideo = getSchedule().getListVideo();
				List<Video> listVideoAvailable = new ArrayList<Video>();
				for (int i = 0; i < listVideo.size(); i++) {
					Video video = getSchedule().getListVideo().get(i);
					if (video.getFileState() == FileState.EXIST) {
						listVideoAvailable.add(video);
					}
				}

				if (listVideoAvailable.size() > 0) {
					Random random = new Random();
					int index = random.nextInt(listVideoAvailable.size());
					setVideo(listVideoAvailable.get(index));
					url = getVideo().getFileLocal().getAbsolutePath();
				}
			}

			if (url != null && url.equalsIgnoreCase("") == false) {
				stop();

				if (mPlayer == null) {
					mPlayer = new MediaPlayer();
					mPlayer.setOnBufferingUpdateListener(this);
					mPlayer.setOnCompletionListener(this);
					mPlayer.setOnErrorListener(this);
					mPlayer.setOnInfoListener(this);
					mPlayer.setOnPreparedListener(this);
					mPlayer.setOnSeekCompleteListener(this);
					mPlayer.setOnVideoSizeChangedListener(this);
				}

				mPlayer.setDataSource(url);
				// Update state
				setStatePlayer(StatePlayer.SETUP_HOLDER);
				mPlayer.setDisplay(holder);

				mPlayer.prepareAsync();
				setStatePlayer(StatePlayer.PREPARE);
			}
		} catch (Exception ex) {
			if (url != null)
				listenerError(new Exception("prePlay: " + url), 0, 0);
			else
				listenerError(ex, 0, 0);
		}
	}

	public void stop() {
		try {
			if (mPlayer != null) {
				if (mPlayer.isPlaying() == true) {
					mPlayer.stop();
					listenerStop();
				}
				mPlayer.reset();
				mPlayer.release();
				mPlayer = null;
			}
		} catch (Exception ex) {
			listenerError(ex, 0, 0);
		}
	}

	public void pause() {
		try {
			stop();
		} catch (Exception ex) {
			listenerError(ex, 0, 0);
		}
	}

	public void resume() {
		try {
			if (getSchedule() != null && isPlaying() == false) {
				play(getSchedule());
			}
		} catch (Exception ex) {
			listenerError(ex, 0, 0);
		}
	}

	public boolean isPlaying() {
		if (mPlayer != null)
			return mPlayer.isPlaying();
		return false;
	}

	@Override
	public void onCompletion(MediaPlayer mp) {
		final Schedule schedule = getSchedule();
		// Bug not looping
		mHandler.postDelayed(new Runnable() {
			@Override
			public void run() {
				if (mPlayer != null && mErrorPlaying == false) {
					play(schedule);
				}
			}
		}, 10);
	}

	@Override
	public void onBufferingUpdate(MediaPlayer mp, int percent) {
	}

	@Override
	public void onVideoSizeChanged(MediaPlayer mp, int width, int height) {
	}

	@Override
	public void onSeekComplete(MediaPlayer mp) {
	}

	@Override
	public void onPrepared(MediaPlayer mp) {
		mPlayer.start();
		listenerStart();
	}

	@Override
	public boolean onInfo(MediaPlayer mp, int what, int extra) {
		return false;
	}

	@Override
	public boolean onError(MediaPlayer mp, int what, int extra) {
		listenerError(new Exception("Player error"), what, extra);
		return false;
	}

	private void listenerError(Exception ex, int what, int extra) {
		mErrorPlaying = true;
		setStatePlayer(StatePlayer.NONE);
		stop();
		if (getListener() != null)
			getListener().playerOnError(ex, what, extra, getSchedule(), getVideo());
	}

	private void listenerStart() {
		mErrorPlaying = false;
		setStatePlayer(StatePlayer.PLAYING);
		if (getListener() != null)
			getListener().playerOnStart();
	}

	private void listenerStop() {
		setStatePlayer(StatePlayer.STOPPED);
		if (getListener() != null)
			getListener().playerOnStop();
	}
}
