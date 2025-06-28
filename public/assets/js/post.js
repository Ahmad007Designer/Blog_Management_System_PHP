$(document).ready(function () {
    // Handle post submission
    $('#postForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/posts/create',
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    alert('Post created successfully');
                    location.reload(); // or dynamically update the post list
                }
            }
        });
    });

    // Handle post deletion
    $('.delete-post').on('click', function () {
        let id = $(this).data('id');
        if (confirm('Are you sure to delete?')) {
            $.ajax({
                url: '/posts/delete/' + id,
                type: 'DELETE',
                success: function (res) {
                    if (res.status === 'deleted') {
                        alert('Post deleted');
                        location.reload(); // or dynamically remove the element
                    }
                }
            });
        }
    });
});
