function checkFinish(id) {
    let control = $('#checkFinish' + id).attr('data-control');
    let isChecked = $('#checkFinish' + id).is(':checked');
    let value = 0;
    if (isChecked) {
        value = 1;
    }
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
                    url:control + '/checkTaskFinish',
                    method: "post",
                    data: {id:id, value:value},
                    dataType: "json",
                    success:function(response){
                        if (response.type === 'successfully') {
                            Swal.fire(
                                'Finished!',
                                response.message,
                                'success'
                            );
                            $('input[type="checkbox"]').each(function(){
                                if (this.checked) {
                                    this.disabled = true;
                                }
                            })
                            $('a[name="editTask' + id + '"]').each(function(){
                                this.remove();
                            })
                        } 
                    }
                })
            }
        })
}