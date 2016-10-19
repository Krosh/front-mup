$(document).ready(
    function () {
        $(".sidebar.left.sidebar-menu").sidebar();
        $(".sidebar.left.sidebar-card").sidebar();
        $("#btnMenu").click(
            function () {
                $(".b-shadow").show();
                $(".sidebar.left.sidebar-card").trigger("sidebar:close");
                $(".sidebar.left.sidebar-menu").trigger("sidebar:open");
            }
        );
        $("#btnMenuClose").click(
            function () {
                $(".b-shadow").hide();
                $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
            }
        );
        $(".btnCardOpen").click(
            function () {
                $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
                $(".sidebar.left.sidebar-card").fadeIn();
            }
        );
        $(".btnCardClose").click(
            function () {
                $(".sidebar.left.sidebar-card").fadeOut();
            }
        );
        $(".b-shadow").click(
            function () {
                $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
                $(".b-shadow").hide();
            }
        );
    }
)