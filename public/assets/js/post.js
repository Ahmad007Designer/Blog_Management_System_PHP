//for Deletion
$(document).ready(function () {
    console.log('post.js loaded');

    $(document).on('click', '.delete-post', function (e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Delete button clicked');

        let id = $(this).data('id');
        var thisEle = $(this);
        if (confirm('Are you sure you want to delete this post?')) {
            $.ajax({
                url: '/posts/delete/' + id,
                type: 'POST',
                data: { _method: 'DELETE' },
                success: function (res) {
                    console.log('Delete success:', res);
                    if (res.status === 'deleted') {
                        alert('Post deleted');
                        // location.reload();
                        thisEle.closest('.card').closest('.col-12').remove();
                        // thisEle.closest('.post-card').remove();

                    } else {
                        alert('Delete failed.');
                    }
                },
                error: function (xhr) {
                    console.error('Delete error:', xhr.responseText);
                    alert('Error deleting post.');
                }
            });
        }
    });
});

//for view window
$(document).ready(function () {
    $('.view-post-btn').on('click', function () {
        const postId = $(this).data('id');

        // $('#viewPostModal').modal('show');
        $('#viewPostModal').fadeIn();
        $('#viewPostContent').html('<div class="text-center text-muted">Loading...</div>');

        $.ajax({
            url: '/posts/view_ajax/' + postId,
            type: 'GET',
            success: function (data) {
                $('#viewPostContent').html(data);
            },
            error: function () {
                $('#viewPostContent').html('<div class="text-danger text-center">Failed to load post.</div>');
            }
        });
    });

    $(document).on('click', '.close-btn, .custom-modal-overlay', function (e) {
        if ($(e.target).is('.custom-modal-overlay') || $(e.target).is('.close-btn')) {
            $('#viewPostModal').fadeOut();
        }
    });
});

//for updated and edit
$(document).ready(function () {
    // Open Edit Modal
    $('.btn-edit-post').on('click', function () {
        const postId = $(this).data('id');
        $('#editPostModal').show();
        $('#editPostContent').html('<div class="text-center text-muted">Loading...</div>');

        $.ajax({
            url: `/posts/edit_ajax/${postId}`,
            type: 'GET',
            success: function (data) {
                $('#editPostContent').html(data);
                // No need to call initCKEditor4 here; it's already called inside the view
            },
            error: function () {
                $('#editPostContent').html('<div class="text-danger text-center">Failed to load editor.</div>');
            }
        });
    });

    // Submit Update Form via AJAX
    $(document).on('submit', '#editPostForm', function (e) {
        e.preventDefault();

        const form = $(this);
        const postId = form.find('input[name="id"]').val();
        const formData = new FormData(this);

        if (CKEDITOR.instances.content) {
            formData.set('content', CKEDITOR.instances.content.getData());
        }

        $.ajax({
            url: `/posts/update_ajax/${postId}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'updated') {
                    alert('Post updated successfully');
                    $('#editPostModal').hide();
                    location.reload(); // Optional: or dynamically update post
                } else {
                    alert('Update failed.');
                }
            },
            error: function () {
                alert('An error occurred while updating.');
            }
        });
    });

    // Close modal when clicking overlay or close button
    $(document).on('click', '.custom-modal-overlay, .close-btn', function (e) {
        if ($(e.target).hasClass('custom-modal-overlay') || $(e.target).hasClass('close-btn')) {
            $('#editPostModal').fadeOut();
        }
    });
});
