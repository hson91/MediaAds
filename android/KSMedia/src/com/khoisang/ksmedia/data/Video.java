package com.khoisang.ksmedia.data;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;

import android.content.Context;
import android.net.Uri;

import com.khoisang.khoisanglibary.network.HttpDownloadHandler;
import com.khoisang.khoisanglibary.network.HttpDownloadManager;
import com.khoisang.khoisanglibary.network.HttpResult;
import com.khoisang.khoisanglibary.util.StorageUtil;

public class Video implements HttpDownloadHandler {

	public interface VideoListener {
		public void downloadFileException(Exception ex, Schedule schedule, Video video);

		public void downloadFileComplete(Schedule schedule, Video video);
	}

	public enum FileState {
		NONEXIST, DOWNLODING, EXIST
	}

	public int videoID;
	public int urlID;
	public String url;
	public long timeStart;
	public long timeEnd;
	// Local
	private File mFileLocal;
	private FileState mFileState = FileState.NONEXIST;
	private Object fileStateObject = new Object();
	// Listener
	private VideoListener listener;

	public VideoListener getListener() {
		return listener;
	}

	public void setListener(VideoListener listener) {
		this.listener = listener;
	}

	public void initWhenOnline(Context context) {
		String fileName = String.valueOf(this.videoID) + "_" + String.valueOf(this.urlID) + this.url.substring(this.url.lastIndexOf("."));
		File filePath = new File(StorageUtil.getDiskCacheDir(context, "video"), fileName);
		setFileLocal(new File(filePath.getAbsolutePath()));

		timeStart = timeStart * 1000;
		timeEnd = timeEnd * 1000;
	}

	private void setFileLocal(File fileLocal) {
		mFileLocal = fileLocal;
		if (exist() == false) {
			setFileState(FileState.NONEXIST);
		} else if (fileLocal.canRead() == true && fileLocal.canWrite()) {
			setFileState(FileState.EXIST);
		}
	}

	public File getFileLocal() {
		return mFileLocal;
	}

	private void setFileState(FileState fileState) {
		synchronized (fileStateObject) {
			this.mFileState = fileState;
		}
	}

	public FileState getFileState() {
		synchronized (fileStateObject) {
			return mFileState;
		}
	}

	private boolean exist() {
		return mFileLocal != null && mFileLocal.exists() == true && mFileLocal.length() > 0;
	}

	public void delete() {
		setFileState(FileState.NONEXIST);
		if (getFileLocal() != null)
			getFileLocal().delete();
	}

	public void download(HttpDownloadManager downloadManager, Schedule schedule, VideoListener videoListener) {
		setListener(videoListener);
		downloadManager.get(0, schedule, Uri.parse(url), this);
	}

	@Override
	public void downloadPrePrequest(int ID, int Name, Object holder) {
		setFileState(FileState.DOWNLODING);
	}

	@Override
	public void downloadHandleException(int ID, int Name, Exception ex, Object holder) {
		listenerDownloadFileException(ex, (Schedule) holder);
	}

	@Override
	public void downloadHandleCancel(int ID, int Name, Object holder) {
		listenerDownloadFileException(new Exception("downloadHandleCancel"), (Schedule) holder);
	}

	@Override
	public void downloadHandleInputStream(int ID, int Name, HttpResult httpResult, InputStream inputStream, Object holder) {
		Exception exception = null;
		FileOutputStream fileOutputStream = null;
		try {
			if (httpResult.StatusCode != 200)
				throw new Exception("Status code is not 200");

			fileOutputStream = new FileOutputStream(getFileLocal());
			byte[] buffer = new byte[1024];
			int len = 0;

			while ((len = inputStream.read(buffer)) > 0) {
				fileOutputStream.write(buffer, 0, len);
				fileOutputStream.flush();
			}
		} catch (Exception ex) {
			exception = ex;
		} finally {
			if (fileOutputStream != null) {
				try {
					fileOutputStream.close();
				} catch (IOException ex) {
					exception = ex;
				}
			}
		} // End finally
		if (exception == null) {
			listenerDownloadFileComplete((Schedule) holder);
		} else {
			listenerDownloadFileException(exception, (Schedule) holder);
		}
	}

	private void listenerDownloadFileComplete(Schedule schedule) {
		setFileState(FileState.EXIST);
		if (getListener() != null)
			getListener().downloadFileComplete(schedule, this);
	}

	private void listenerDownloadFileException(Exception exception, Schedule schedule) {
		delete();
		if (getListener() != null)
			getListener().downloadFileException(exception, schedule, this);
	}
}
