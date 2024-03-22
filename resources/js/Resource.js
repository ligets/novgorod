let browseFile = $('#browseFile');
    let resumable = new Resumable({
        target: '/resources/upload',
        query: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: '1',
            tags: 'Ex1, Ex2, Ex3',
            title: "Это название ресурса"
            // in_album: '1'
        },
        fileType: [
            // RAW
            'CRW', 'CR2', 'NEF', 'NRW', 'ARW', 'RW2', 'ORF', 'RAF', 'DCR', 'SRW', 'RWL', 'MOS',
            //DNG
            'DNG',
            //image
            'png', 'jpeg', 'jpg', 'gif', 'webp', 'bmp', 'ico',
            //video
            'mp4', 'ogv', 'webm', 'avi', 'mpeg', 'mpg', 'mov', 'wmv'
        ],
        chunkSize: 2 * 1024 * 1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        console.log(response);
        response = JSON.parse(response);
        
        if (response.mime_type.includes("image")) {
            $('#imagePreview').attr('src', response.path + '/' + response.name).show();
        }

        if (response.mime_type.includes("video")) {
            $('#videoPreview').attr('src', response.path + '/' + response.name).show();
        }

        $('.card-footer').show();
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    let progress = $('.progress');

    function showProgress() {
        progress.find('.progress-bar').css('width', '0%');
        progress.find('.progress-bar').html('0%');
        progress.find('.progress-bar').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)

        if (value === 100) {
            progress.find('.progress-bar').addClass('bg-success');
            setTimeout(function() {
                progress.hide();
            }, 500);
        }
    }

    function hideProgress() {
        progress.hide();
    }