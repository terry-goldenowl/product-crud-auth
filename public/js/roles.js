$(".addPermissionsBtn").click(function () {
    var roleId = $(this).closest("tr").find("td").first().text();

    $("#choosePermissionModal" + roleId).modal("show");
});

$("#addRoleBtn").on("click", function () {
    $("#addRoleModal").modal("show");
    $("#addRoleForm").attr("action", "/users/roles");
});
