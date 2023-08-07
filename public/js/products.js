// Handle Update button click event
$("#products-table").on("click", ".update-btn", function () {
    var rowData = $(this)
        .closest("tr")
        .find("td")
        .map(function () {
            return $(this).text();
        })
        .get();

    $("#name").val(rowData[1]);
    $("#price").val(rowData[2]);
    $("#image").val(rowData[3]);
    $("#description").val(rowData[4]);

    $("#updateProductForm").attr("action", "/products/" + rowData[0]);
    $("#updateProductModal").modal("show");
});

$("#products-table").on("click", ".delete-btn", function () {
    var rowData = $(this)
        .closest("tr")
        .find("td")
        .map(function () {
            return $(this).text();
        })
        .get();

    $("#p-id").text("Id: " + rowData[0]);
    $("#p-name").text("Name: " + rowData[1]);
    $("#p-price").text("Price: " + rowData[2]);
    $("#p-image").text("Image URL: " + rowData[3]);
    $("#p-description").text("Description: " + rowData[4]);

    $("#deleteProductForm").attr("action", "/products/" + rowData[0]);
    $("#deleteProductModal").modal("show");
});

$("#createProductBtn").on("click", function () {
    $("#deleteProductForm").attr("action", "/products");
    $("#createProductModal").modal("show");
});
