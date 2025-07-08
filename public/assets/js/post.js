$(document).ready(function () {
    // --- Search Filter by Author ---
    $('#searchInput').on('keyup', function () {
        const query = $(this).val().toLowerCase();
        $('.post-card').each(function () {
            const author = $(this).data('author');
            $(this).toggle(author.toLowerCase().includes(query));
        });
    });


    // --- View Post Modal ---
    function viewbutton() {
        $('.view-post-btn').off('click').on('click', function () {
            const postId = $(this).data('id');
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
    }
    viewbutton();

    // --- Delete Post via AJAX ---
    function deletebutton() {
        $('.delete-post').off('click').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const id = $(this).data('id');
            const Button = $(this);
            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    url: '/posts/delete/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.status === 'deleted') {
                            alert('Post deleted');
                            Button.closest('.card').closest('.col-12').remove();
                        } else {
                            alert('Delete failed.');
                        }
                    },
                    error: function () {
                        alert('Error deleting post.');
                    }
                });
            }
        });
    }
    deletebutton();

    // --- Edit Post Modal ---
    function editbutton() {
        $('.btn-edit-post').off('click').on('click', function () {
            const postId = $(this).data('id');
            $('#editPostModal').fadeIn();
            $('#editPostContent').html('<div class="text-center text-muted">Loading...</div>');

            $.ajax({
                url: `/posts/edit_ajax/${postId}`,
                type: 'GET',
                success: function (data) {
                    $('#editPostContent').html(data);
                },
                error: function () {
                    $('#editPostContent').html('<div class="text-danger text-center">Failed to load editor.</div>');
                }
            });
        });
    }
    editbutton();

    // --- Submit Edit Form via AJAX ---
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
                    $('#postctr-' + postId).remove();
                    $('#postsContainer').prepend(response.post_html);

                    editbutton();
                    viewbutton();
                    deletebutton();
                } else {
                    alert('Update failed.');
                }
            },
            error: function () {
                alert('An error occurred while updating.');
            }
        });
    });


    // Open Create Modal
    $('#createPostBtn').on('click', function () {
        $('#createPostModal').fadeIn();
        $('#createPostContent').html('<div class="text-center text-muted">Loading form...</div>');

        $.ajax({
            url: '/posts/create_post',
            type: 'GET',
            success: function (data) {
                $('#createPostContent').html(data);
            },
            error: function () {
                $('#createPostContent').html('<div class="text-danger text-center">Failed to load form.</div>');
            }
        });
    });

    // Submit Create Form
    $(document).on('submit', '#createPostForm', function (e) {
        e.preventDefault();

        const form = $(this);
        const formData = new FormData(this);

        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.content) {
            formData.set('content', CKEDITOR.instances.content.getData());
        }

        $.ajax({
            url: '/posts/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    alert('Post created successfully');
                    $('#createPostModal').fadeOut();
                    $('#postsContainer').prepend(res.html);

                    editbutton();
                    deletebutton();
                    viewbutton();
                } else {
                    alert(res.message || 'Failed to create post.');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error while creating post.');
            }
        });
    });

    
   // This version only closes when clicking the close button, not the overlay
    $(document).on('click', '.close-btn', function (e) {
        $('#editPostModal').fadeOut();
        $('#viewPostModal').fadeOut();
        $(this).closest('.custom-modal-overlay').fadeOut();
    });
});
