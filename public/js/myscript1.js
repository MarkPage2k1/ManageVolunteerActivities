function accept(id) {
    let control = $('#accept' + id).attr('data-control')
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:control + '/acceptActivity',
                    method: "post",
                    data: {id:id},
                    dataType: "json",
                    success:function(response){
                        if (response.result === 'true') {
                            Swal.fire(
                                'Accepted!',
                                response.message,
                                'success'
                            );
                            $('.even' + id).remove();
                        } 
                    }
                })
            }
        })
}

function refuse(id) {
    let control = $('#refuse' + id).attr('data-control')
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, refuse it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:control + '/refuseActivity',
                    method: "post",
                    data: {id:id},
                    dataType: "json",
                    success:function(response){
                        if (response.result === 'true') {
                            Swal.fire(
                                'Refused!',
                                response.message,
                                'success'
                            );
                            $('.even' + id).remove();
                        } 
                    }
                })
            }
        })
}






function del(id) {
    let control = $('#del' + id).attr('data-control')
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:control + '/delete',
                    method: "post",
                    data: {id:id},
                    dataType: "json",
                    success:function(response){
                        if (response.result === 'true') {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            $('.even' + id).remove();
                        } 
                    }
                })
            }
        })
}

function delAll(__this) {
    let control = $(__this).attr('data-control');
    console.log(control)
    let listID = '';
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('input[name="foo"]').each(function(){
                    if (this.checked) {
                        listID = listID + ',' + this.value
                    }
                })
                listID = listID.substr(1);
                if(listID !== '') {
                    $.ajax({
                        url:control + '/delAll',
                        method: "post",
                        data: {listID:listID},
                        dataType: "json",
                        success:function(response){
                            if (response.result === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                $('input[name="foo"]').each(function(){
                                    if (this.checked) {
                                        $('.even' + this.value).remove();
                                    }
                                })
                            } 
                        }
                    })
                } else {
                    Swal.fire(
                        'ERROR!',
                        'Vui long chon muc can xoa',
                        'warning'
                    );
                }
            }
        });
}

$(document).ready(function() {
    setTimeout(() => {
        $('#MessageFlash').hide(500);
    }, 1000);
});

function checkPublish(id, fields) {
    let control = $('#' + fields + id).attr('data-control');
    let isChecked = $('#' + fields + id).is(':checked');
    let value = 0;
    if (isChecked) {
        value = 1;
    }
    $.ajax({
        url:control + '/checkPublish',
        method: "post",
        data: {id:id, value:value, fields:fields},
        dataType: "json",
        success:function(response){
            if (response.type === 'successfully') {
                Swal.fire(
                    'Updated!',
                    response.message,
                    'success'
                );
                $('input[name="foo"]').each(function(){
                    if (this.checked) {
                        $('.even' + this.value).remove();
                    }
                })
            } 
        }
    })
}