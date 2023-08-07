$("#addPermissionBtn").on("click", function () {
    $("#addPermissionModal").modal("show");
    $("#addPermissionForm").attr("action", "/users/permissions");
});
