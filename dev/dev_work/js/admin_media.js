$(document).ready(function() {
        $('#file_upload').uploadify({
			'buttonText' : 'Add Media File',
            'swf'      : '../uploadify/uploadify.swf',
            'uploader' : '../uploadify/uploadify.php',
			'formData': { 'userid': userid, 'table': 'admin'},
            'auto'      : true,
			'onUploadSuccess' : function(file, data, response) {
				$('#media_holder').append('<div class="media_item"><img src=//data-storyblox.omixorp.com/'+data+'></div>');
			}
        });
	
		$('#accordion').accordion({
			collapsible: true
		});
});