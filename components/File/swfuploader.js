/****************************** from multi/swfupload.queue.js ************************/
/*
	Queue Plug-in
	
	Features:
		*Adds a cancelQueue() method for cancelling the entire queue.
		*All queued files are uploaded when startUpload() is called.
		*If false is returned from uploadComplete then the queue upload is stopped.
		 If false is not returned (strict comparison) then the queue upload is continued.
		*Adds a QueueComplete event that is fired when all the queued files have finished uploading.
		 Set the event handler with the queue_complete_handler setting.
		
*/

var SWFUpload;
if (typeof(SWFUpload) === "function") {
	SWFUpload.queue = {};
	
	SWFUpload.prototype.initSettings = (function (oldInitSettings) {
		return function () {
			if (typeof(oldInitSettings) === "function") {
				oldInitSettings.call(this);
			}
			
			this.queueSettings = {};
			
			this.queueSettings.queue_cancelled_flag = false;
			this.queueSettings.queue_upload_count = 0;
			
			this.queueSettings.user_upload_complete_handler = this.settings.upload_complete_handler;
			this.queueSettings.user_upload_start_handler = this.settings.upload_start_handler;
			this.settings.upload_complete_handler = SWFUpload.queue.uploadCompleteHandler;
			this.settings.upload_start_handler = SWFUpload.queue.uploadStartHandler;
			
			this.settings.queue_complete_handler = this.settings.queue_complete_handler || null;
		};
	})(SWFUpload.prototype.initSettings);

	SWFUpload.prototype.startUpload = function (fileID) {
		this.queueSettings.queue_cancelled_flag = false;
		this.callFlash("StartUpload", [fileID]);
	};

	SWFUpload.prototype.cancelQueue = function () {
		this.queueSettings.queue_cancelled_flag = true;
		this.stopUpload();
		
		var stats = this.getStats();
		while (stats.files_queued > 0) {
			this.cancelUpload();
			stats = this.getStats();
		}
	};
	
	SWFUpload.queue.uploadStartHandler = function (file) {
		var returnValue;
		if (typeof(this.queueSettings.user_upload_start_handler) === "function") {
			returnValue = this.queueSettings.user_upload_start_handler.call(this, file);
		}
		
		// To prevent upload a real "FALSE" value must be returned, otherwise default to a real "TRUE" value.
		returnValue = (returnValue === false) ? false : true;
		
		this.queueSettings.queue_cancelled_flag = !returnValue;

		return returnValue;
	};
	
	SWFUpload.queue.uploadCompleteHandler = function (file) {
		var user_upload_complete_handler = this.queueSettings.user_upload_complete_handler;
		var continueUpload;
		
		if (file.filestatus === SWFUpload.FILE_STATUS.COMPLETE) {
			this.queueSettings.queue_upload_count++;
		}

		if (typeof(user_upload_complete_handler) === "function") {
			continueUpload = (user_upload_complete_handler.call(this, file) === false) ? false : true;
		} else if (file.filestatus === SWFUpload.FILE_STATUS.QUEUED) {
			// If the file was stopped and re-queued don't restart the upload
			continueUpload = false;
		} else {
			continueUpload = true;
		}
		
		if (continueUpload) {
			var stats = this.getStats();
			if (stats.files_queued > 0 && this.queueSettings.queue_cancelled_flag === false) {
				this.startUpload();
			} else if (this.queueSettings.queue_cancelled_flag === false) {
				this.queueEvent("queue_complete_handler", [this.queueSettings.queue_upload_count]);
				this.queueSettings.queue_upload_count = 0;
			} else {
				this.queueSettings.queue_cancelled_flag = false;
				this.queueSettings.queue_upload_count = 0;
			}
		}
	};
}



/****************************** FileProgress ************************/
/*
	A simple class for displaying file information and progress
	Note: This is a demonstration only and not part of SWFUpload.
	Note: Some have had problems adapting this class in IE7. It may not be suitable for your application.
*/

// Constructor
// file is a SWFUpload file object
// targetID is the HTML element id attribute that the FileProgress HTML structure will be added to.
// Instantiating a new FileProgress object with an existing file will reuse/update the existing DOM elements

function FileProgress(file, targetID) {
	this.fileProgressID = file.id;

	this.opacity = 100;
	this.height = 0;
	

	this.fileProgressWrapper = document.getElementById(this.fileProgressID);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.fileProgressID;

		this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

		var progressCancel = document.createElement("a");
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressText = document.createElement("div");
		progressText.className = "progressName";
		progressText.appendChild(document.createTextNode(file.name));

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

		this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressText);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);

		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		document.getElementById(targetID).appendChild(this.fileProgressWrapper);
	} else {
		this.fileProgressElement = this.fileProgressWrapper.firstChild;
		this.reset();
	}

	this.height = this.fileProgressWrapper.offsetHeight;
	this.setTimer(null);

}

FileProgress.prototype.setTimer = function (timer) {
	this.fileProgressElement["FP_TIMER"] = timer;
};
FileProgress.prototype.getTimer = function (timer) {
	return this.fileProgressElement["FP_TIMER"] || null;
};

FileProgress.prototype.reset = function () {
	this.fileProgressElement.className = "progressContainer";

	this.fileProgressElement.childNodes[2].innerHTML = "&nbsp;";
	this.fileProgressElement.childNodes[2].className = "progressBarStatus";
	
	this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = "0%";
	
	this.appear();	
};

FileProgress.prototype.setProgress = function (percentage) {
	this.fileProgressElement.className = "progressContainer green";
	this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = percentage + "%";

	this.appear();	
};
FileProgress.prototype.setComplete = function () {
	this.fileProgressElement.className = "progressContainer blue";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";
	this.fileProgressElement.childNodes[3].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
		oSelf.disappear();
	}, 10000));
};
FileProgress.prototype.setError = function () {
	this.fileProgressElement.className = "progressContainer red";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
		oSelf.disappear();
	}, 5000));
};
FileProgress.prototype.setCancelled = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

	var oSelf = this;
	this.setTimer(setTimeout(function () {
		oSelf.disappear();
	}, 2000));
};
FileProgress.prototype.setStatus = function (status) {
	this.fileProgressElement.childNodes[2].innerHTML = status;
};

// Show/Hide the cancel button
FileProgress.prototype.toggleCancel = function (show, swfUploadInstance) {
	this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
	if (swfUploadInstance) {
		var fileID = this.fileProgressID;
		this.fileProgressElement.childNodes[0].onclick = function () {
			swfUploadInstance.cancelUpload(fileID);
			return false;
		};
	}
};

FileProgress.prototype.appear = function () {
	if (this.getTimer() !== null) {
		clearTimeout(this.getTimer());
		this.setTimer(null);
	}
	
	if (this.fileProgressWrapper.filters) {
		try {
			this.fileProgressWrapper.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 100;
		} catch (e) {
			// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
			this.fileProgressWrapper.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=100)";
		}
	} else {
		this.fileProgressWrapper.style.opacity = 1;
	}
		
	this.fileProgressWrapper.style.height = "";
	
	this.height = this.fileProgressWrapper.offsetHeight;
	this.opacity = 100;
	this.fileProgressWrapper.style.display = "";
	
};

// Fades out and clips away the FileProgress box.
FileProgress.prototype.disappear = function () {

	var reduceOpacityBy = 15;
	var reduceHeightBy = 4;
	var rate = 30;	// 15 fps

	if (this.opacity > 0) {
		this.opacity -= reduceOpacityBy;
		if (this.opacity < 0) {
			this.opacity = 0;
		}

		if (this.fileProgressWrapper.filters) {
			try {
				this.fileProgressWrapper.filters.item("DXImageTransform.Microsoft.Alpha").opacity = this.opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				this.fileProgressWrapper.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=" + this.opacity + ")";
			}
		} else {
			this.fileProgressWrapper.style.opacity = this.opacity / 100;
		}
	}

	if (this.height > 0) {
		this.height -= reduceHeightBy;
		if (this.height < 0) {
			this.height = 0;
		}

		this.fileProgressWrapper.style.height = this.height + "px";
	}

	if (this.height > 0 || this.opacity > 0) {
		var oSelf = this;
		this.setTimer(setTimeout(function () {
			oSelf.disappear();
		}, rate));
	} else {
		this.fileProgressWrapper.style.display = "none";
		this.setTimer(null);
	}
};


/* ********************** Event Handlers ********************** */

var UploadHandlers = {
	fileDialogStart: function() {
	},
	fileQueued: function(file) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setStatus("Pending...");
			progress.toggleCancel(true, this);

		} catch (ex) {
			this.debug(ex);
		}

	},

	fileQueueError: function(file, errorCode, message) {
		try {
			if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
				alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
				return;
			}

			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setError();
			progress.toggleCancel(false);

			switch (errorCode) {
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				progress.setStatus("File is too big.");
				this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				progress.setStatus("Cannot upload Zero Byte files.");
				this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
				progress.setStatus("Invalid File Type.");
				this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
				alert("You have selected too many files.  " +  (message > 1 ? "You may only add " +  message + " more files" : "You cannot add any more files."));
				break;
			default:
				if (file !== null) {
					progress.setStatus("Unhandled Error");
				}
				this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			}
		} catch (ex) {
			this.debug(ex);
		}
	},

	fileDialogComplete: function(numFilesSelected, numFilesQueued) {
		try {
			if (this.getStats().files_queued > 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = false;
			}
			
			/* I want auto start and I can do that here */
			this.startUpload();
		} catch (ex)  {
			this.debug(ex);
		}
	},

	uploadStart: function(file) {
		try {
			/* I don't want to do any file validation or anything,  I'll just update the UI and return true to indicate that the upload should start */
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setStatus("Uploading...");
			progress.toggleCancel(true, this);
		}
		catch (ex) {
		}
		
		return true;
	},

	uploadProgress: function(file, bytesLoaded, bytesTotal) {

		try {
			var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setProgress(percent);
			progress.setStatus("Uploading...");
		} catch (ex) {
			this.debug(ex);
		}
	},

	uploadSuccess: function(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("Complete.");
			progress.toggleCancel(false);

		} catch (ex) {
			this.debug(ex);
		}
	},

	uploadComplete: function(file) {
		try {
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			} else {	
				this.startUpload();
			}

			// insert values 
			if ( file.id == 'SWFUpload_0_0' ) {
				target = $('#FileBrowser .thumbnail');
			}
			var src = $('#FileWrite [type=file]').attr('data-upload-href') + '/' + file.name;
			var image = $('<li><img src="' + src + '" /></li>');

			target.append( image );
		} catch (ex) {
			this.debug(ex);
		}
	},

	uploadError: function(file, errorCode, message) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setError();
			progress.toggleCancel(false);

			switch (errorCode) {
			case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
				progress.setStatus("Upload Error: " + message);
				this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
				progress.setStatus("Configuration Error");
				this.debug("Error Code: No backend file, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
				progress.setStatus("Upload Failed.");
				this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.IO_ERROR:
				progress.setStatus("Server (IO) Error");
				this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
				progress.setStatus("Security Error");
				this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				progress.setStatus("Upload limit exceeded.");
				this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
				progress.setStatus("File not found.");
				this.debug("Error Code: The file was not found, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
				progress.setStatus("Failed Validation.  Upload skipped.");
				this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
				if (this.getStats().files_queued === 0) {
					document.getElementById(this.customSettings.cancelButtonId).disabled = true;
				}
				progress.setStatus("Cancelled");
				progress.setCancelled();
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				progress.setStatus("Stopped");
				break;
			default:
				progress.setStatus("Unhandled Error: " + error_code);
				this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			}
		} catch (ex) {
			this.debug(ex);
		}
	}
};



/************************* Swfuploader ***********************/
var Swfuploader = {
	create: function ( el ) {
		var uploader = new SWFUpload( Swfuploader.createOptions( el ) );

		$('.swfupload .btnCancel').click( function( ev ) {
			ev.preventDefault();
			uploader.cancelQueue();
		});
	},
	createOptions: function( form ) {
		var file = form.find('[type=file]');
		var button = form.find('button');

		var options = {
			// Backend Settings
			upload_url: form.attr('action'),
			post_params: {
				"PHPSESSID" : form.find('[name=PHPSESSID]').val()
			},

			// File Upload Settings
			file_size_limit : form.find('[name=MAX_FILE_SIZE]').val(),
			file_types : file.attr('data-types'),
			file_types_description : file.attr('title'),
			file_upload_limit : file.attr('data-uploadLimit'),
			file_queue_limit : file.attr('data-queueLimit'),

			// Event Handler Settings
			file_dialog_start_handler : UploadHandlers.fileDialogStart,
			file_queued_handler : UploadHandlers.fileQueued,
			file_queue_error_handler : UploadHandlers.fileQueueError,
			file_dialog_complete_handler : UploadHandlers.fileDialogComplete,
			upload_start_handler : UploadHandlers.uploadStart,
			upload_progress_handler : UploadHandlers.uploadProgress,
			upload_error_handler : UploadHandlers.uploadError,
			upload_success_handler : UploadHandlers.uploadSuccess,
			upload_complete_handler : UploadHandlers.uploadComplete,

			// Button Settings
			button_image_url: button.css('background-image').match(/http:.*[png|jpg|gif]/),
			button_placeholder_id: button.attr('id'),
			button_width: button.css('width').match(/[0-9]*/),
			button_height: button.css('height').match(/[0-9]*/),

			button_text : button.html(),
			button_text_style : '',
			button_text_top_padding: button.css('padding-top').match(/[0-9]*/),
			button_text_left_padding: button.css('padding-left').match(/[0-9]*/),
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : file.attr('data-swf-href'),

			custom_settings : {
				progressTarget : form.find('.progress').attr('id'),
				cancelButtonId : form.find('.btnCancel').attr('id')
			},
			
			// Debug Settings
			debug: false
		}
		return options;
	}
}
