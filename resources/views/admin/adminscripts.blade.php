<script>
    //Admin scripts
    function verifyUser(userId) {
        $.ajax({
            url: '/admin/user/verify/' + userId,
            method: 'get',
            success: function (response) {
                alert(response.message);
                if (response.data == 'verified') {
                    $('#user-span-'+userId).html('yes');
                    $('#user-span-'+userId).removeClass('label-default').removeClass('label-pending').addClass('label-success');
                    $('#verify-link-' + userId).html('Unverify');
                    /*
                    $('#user-span-'+userId).addClass('label-default');
*/

                }else{
                    $('#user-span-'+userId).html('no');
                    $('#user-span-'+userId).removeClass('label-success').addClass('label-default');
                    $('#verify-link-' + userId).html('Verify');

                }
            },
            error:function(response) {
                console.log(response);
            }
        });
    }
    function deleteUser(userId) {
        $.ajax({
            url: '/admin/deleteuser/' + userId,
            method: 'get',
            success: function (response) {
                alert(response.message);
                $('#user-' + userId).remove();
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
function makeAdmin(userId) {
    $.ajax({
        url: '/admin/addadmin/' + userId,
        method: 'get',
        success:function(response) {
            alert(response.message);
            $('#make-admin' + userId).parent().html('Admin');
        }
    })
}
    function verifyBusiness(businessId) {
        $.ajax({
            url: '/admin/business/verify/' + businessId,
            method: 'get',
            success: function (response) {
                alert(response.message);
                if (response.data == 'verified') {
                    $('#business-span-'+businessId).html('yes');
                    $('#business-span-'+businessId).removeClass('label-default').removeClass('label-pending').addClass('label-success');
                    $('#verify-business-' + businessId).html('Unverify')
                    /*
                                        $('#user-span-'+businessId).addClass('label-default');
                    */

                }else{
                    $('#business-span-'+businessId).html('no');
                    $('#business-span-'+businessId).removeClass('label-success').addClass('label-default');
                    $('#verify-business-' + businessId).html('Verify')

                }
            },
            error:function(response) {
                console.log(response);
            }
        });
    }
    function deletebusiness(businessId) {
        $.ajax({
            url: '/admin/business/delete/' + businessId,
            method: 'get',
            success: function (response) {
                alert(response.message);
                $('#business-' + businessId).remove();
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
    function promoteBusiness(businessId) {

        $.ajax({
            url: '/promote/' + businessId,
            method: 'get',
            success: function (response) {
                alert(response.message);
                $('#business-' + businessId).remove();
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
    /*
        $(document).ready(function () {
            $('.verify-button').each(function (i, e) {
                $(e).click(function (event) {
                    $.ajax({
                        url: $(e).attr('data-url'),
                        method: 'get',
                        success: function (response) {
                            alert(response.message);
                            if ($(e).html() == 'Verify') {
                                $(this).html('Unverify');
                                $(this).attr('data-url', '/admin/user/unverify/' + $(this).parents('.user-detail-row').attr('data-user-id'));
                            } else {
                                $(e).html('Verify');
                                $(this).attr('data-url', '/admin/user/verify/' + $(this).parents('.user-detail-row').attr('data-user-id'));
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                });
            });

            $('.delete-user-button').each(function (i, e) {
                click(function () {
                    $.ajax({
                        url: $(e).attr('data-url'),
                        method: 'get',
                        success: function (response) {
                            alert(response.message);
                            $(e).parents('.user-detail-row').remove();
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                });
            });
        });
    */
</script>

