$(".assignRolesBtn").click(function () {
    var userId = $(this).closest("tr").find("td").first().text();
    console.log(userId);

    $("#assignRolesModal" + userId).modal("show");
});
