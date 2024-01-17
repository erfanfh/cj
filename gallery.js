$(document).ready(function() {
    var isDragging = false;
    var startPos;

    $(".gallery-container1").on("mousedown touchstart", function(e) {
        isDragging = true;
        startPos = e.pageX || e.originalEvent.touches[0].pageX;
    });

    $(document).on("mouseup touchend", function() {
        isDragging = false;
    });

    $(document).on("mousemove touchmove", function(e) {
        if (isDragging) {
            var currentPos = e.pageX || e.originalEvent.touches[0].pageX;
            var distance = (startPos - currentPos) / 2;

            $(".gallery-container1").scrollLeft($(".gallery-container1").scrollLeft() + distance);
            startPos = currentPos;
        }
    });
});

$(document).ready(function() {
    var isDragging = false;
    var startPos;

    $(".gallery-container2").on("mousedown touchstart", function(e) {
        isDragging = true;
        startPos = e.pageX || e.originalEvent.touches[0].pageX;
    });

    $(document).on("mouseup touchend", function() {
        isDragging = false;
    });

    $(document).on("mousemove touchmove", function(e) {
        if (isDragging) {
            var currentPos = e.pageX || e.originalEvent.touches[0].pageX;
            var distance = (startPos - currentPos) / 2;

            $(".gallery-container2").scrollLeft($(".gallery-container2").scrollLeft() + distance);
            startPos = currentPos;
        }
    });
});

$(document).ready(function() {
    var isDragging = false;
    var startPos;

    $(".gallery-container3").on("mousedown touchstart", function(e) {
        isDragging = true;
        startPos = e.pageX || e.originalEvent.touches[0].pageX;
    });

    $(document).on("mouseup touchend", function() {
        isDragging = false;
    });

    $(document).on("mousemove touchmove", function(e) {
        if (isDragging) {
            var currentPos = e.pageX || e.originalEvent.touches[0].pageX;
            var distance = (startPos - currentPos) / 2;

            $(".gallery-container3").scrollLeft($(".gallery-container3").scrollLeft() + distance);
            startPos = currentPos;
        }
    });
});

