$(document).ready(function () {
    $('#query').on('input', function () {
        var query = $(this).val();

        if (query.length >= 2) {
            $.ajax({
                url: 'index.php',
                type: 'GET',
                data: { query: query },
                dataType: 'json',
                success: function (data) {
                    displayResults(data);
                }
            });
        } else {
            $('#search-results').empty();
        }
    });

    function displayResults(results) {
        var resultList = $('#search-results');
        resultList.empty();

        if (results.length > 0) {
            results.forEach(function (result) {
                resultList.append('<li><a href=buy-product/' + result.url +'>' + result.title + ' ' + result.icon + '</a></li>');
            });
        } else {
            resultList.append('<li>محصولی یافت نشد</li>');
        }
    }
});