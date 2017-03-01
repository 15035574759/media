// 页面加载完成后调用
        $(function(){
            // 为所有的父节点添加点击事件
            $(".tree_node_parent_checkbox").click(function(){
                // 获取父节点是否选中
                var isChange = $(this).prop("checked");
                if(isChange){ // 如果选中,则父节点下的所有的子节点都选中
                    // 获取当前checkbox节点的兄弟节点下的所有的checkbox子节点选中
                    $(this).next().find(".tree_node_child_checkbox").prop("checked", true);
                }else{ // 未选中，取消全选
                    // 获取当前checkbox节点的兄弟节点下的所有的checkbox子节点选中
                    $(this).next().find(".tree_node_child_checkbox").removeAttr("checked");
                }
            });
            // 为所有的子节点添加点击事件
            $(".tree_node_child_checkbox").click(function () {
                // 获取选中的节点的父节点下的所有子节点选中的数量
                var length = $(this).parent().find(".tree_node_child_checkbox:checked").length;
                // 判断当前结点是否选中
                if($(this).prop("checked")){ // 选中
                    // 如果当前节点选中后,所有的选中节点数量1，选中父节点
                    if(length == 1){
                        // 选中父节点
                        $(this).parent().prev().prop("checked", true);
                    }
                }else{ // 节点未选中
                    if(length == 0){
                        // 取消父节点的选中状态
                        $(this).parent().prev().removeAttr("checked");
                    }
                }
            });

            // 为所有的切换按钮添加点击事件
            $(".tree_node_toggle_button").click(function () {
                // 获取需要隐藏或显示的节点
                var $toggle_node = $(this).parent().next().find(".tree_node_child");
                $toggle_node.toggle(); // 切换隐藏或显示
                // 切换按钮的显示
                if($toggle_node.is(":visible")){
                    $(this).val("-");
                }else{
                    $(this).val("+");
                }
            });
        });