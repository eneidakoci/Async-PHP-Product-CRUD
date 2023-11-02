$(document).ready(function(){

    $(document).on('click','#btn-add',function(e) {
        var formData = $("#add_form").serialize();//elementet e formes ne seri
        $.ajax({
            data: formData,
            type: "post",
            url: "crud.php",
            success: function(dataResult){
                dataResult = JSON.parse(dataResult);//per ta kthyer str ne js object

                if(dataResult.statusCode == 200){
                    $('tbody').append(dataResult.newProduct);
                    $('#addProduct').modal('hide');
                    $("#add_form")[0].reset();
                    $('.alert').text(dataResult.message);
                    $('.alert').removeClass('d-none');
                }
                else if(dataResult.statusCode == 400){//nuk proc dot te dhenat
                    let errorsHtml = '';
                    Object.entries(dataResult.errors).forEach(([key, value]) => {
                        errorsHtml = errorsHtml + '<p><small class="error">' + value + '</small></p>'
                    });
                    $('.addErrors').html(errorsHtml);
                }
                else if(dataResult.statusCode == 500){
                    alert(dataResult.message);
                }
            }
        });
    });



    let editProduct;
    $(document).on('click','#update',function(e) {
        editProduct = $(this).parent();
        let id = ($(this).siblings('#idTable').text()).trim();
        let name = ($(this).siblings('#nameTable').text()).trim();
        let description = ($(this).siblings('#descriptionTable').text()).trim();
        let price = ($(this).siblings('#priceTable').text()).trim();
        let unitInStock = ($(this).siblings('#unitInStockTable').text()).trim();
       
        $('#idEdit').val(id);
        $('#nameEdit').val(name);
		$('#descriptionEdit').val(description);
		$('#priceEdit').val(price);
		$('#unitInStockEdit').val(unitInStock);
	});

    $(document).on('click','#btn-edit',function(e) {
        var data = $("#edit_form").serialize();

        $.ajax({
            data: data,
            type: "post",
            url: "crud.php",
            success: function(dataResult){
                console.log(dataResult);
                dataResult = JSON.parse(dataResult);

                if(dataResult.statusCode == 200){
                    editProduct.replaceWith(dataResult.editProduct);
                    $('#editProduct').modal('hide');
                    $("#edit_form")[0].reset();
                    $('.alert').text(dataResult.message);
                    $('.alert').removeClass('d-none');
                }
                else if(dataResult.statusCode == 400){
                    let errorsHtml = '';
                    Object.entries(dataResult.errors).forEach(([key, value]) => {
                        errorsHtml = errorsHtml + '<p><small class="error">' + value + '</small></p>'
                    });
                    $('.editErrors').html(errorsHtml);
                }
                else if(dataResult.statusCode == 500){
                    alert(dataResult.message);
                }
            }
        });
    });


    
    let deleteProduct;
    $(document).on("click", "#delete", function() { 
        deleteProduct = $(this);
        let id = ($(this).siblings('#idTable').text()).trim();
        $('#idDelete').val(id);
		
	});

	$(document).on("click", "#btn-delete", function() { 
        $.ajax({
            data: {
                id: $("#idDelete").val(),
                type: "delete"
            },
            type: "get",
            url: "crud.php",
            success: function(dataResult){
                dataResult = JSON.parse(dataResult);

                if(dataResult.statusCode == 200){
                    deleteProduct.parent().remove();
                    $('#deleteProduct').modal('hide');
                    $("#delete_form")[0].reset();
                    $('.alert').text(dataResult.message);
                    $('.alert').removeClass('d-none');
                }
                else if(dataResult.statusCode == 500){
                    alert(dataResult.message);
                }
            }
        });
	});
    
    


});
