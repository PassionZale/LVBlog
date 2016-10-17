export const show_alert_basic = function(msg) {
    swal(msg);
}

export const show_alert_type = function(msg, remark, type) {
    swal(msg, remark, type);
}

export const show_alert_delete = function(callback) {
    swal({
        title: "确定要进行该操作?",
        text: "操作无法回滚!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "取消",
        confirmButtonText: "确定",
        closeOnConfirm: false
    }, function() {
        callback();
        swal("操作成功!","删除的数据将无法找回", "success");
    });
}
