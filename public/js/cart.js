$(".btn-cong, .btn-tru").on("click", function(){
    var type = $(this).attr("data-type");
    console.log(type)
    var parent = $(this).parent();
    var input_solg = parent.find(".input_solg");
    var solg = input_solg.val();
    if (type == "cong"){
        solg = parseInt(solg) + 1;
    }else{
        if (solg > 1){
            solg = parseInt(solg) - 1; 
        }
    }
    
    input_solg.val(solg);

    var price = input_solg.attr("data-price");
    var total_1sp = solg * price;

    var parents = $(this).parents(".action");
    parents.find(".total-1sp").text(formatPrice(total_1sp)+"đ");
    var total = totalPrice()
    $("#total").text(formatPrice(total)+ "đ")

})


$(".btn-xoa").on("click", function(){
    $(this).parents(".row").remove();
    var total = totalPrice()
    $("#total").text(formatPrice(total)+ "đ")
})

function formatPrice(total){
    return total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

function totalPrice(){
    var total = 0
    $(".solg_sp").each(function(){
        var solg = $(this).find(".input_solg").val()
        var price = $(this).find(".input_solg").attr("data-price")
        console.log(price)
        var total_1sp = solg * price
        total = total + parseInt(total_1sp)
    })
    return total
}