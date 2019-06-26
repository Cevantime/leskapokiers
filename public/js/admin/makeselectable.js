function selectize(fieldName, labelFieldName, searchFieldName, routeName) {
    $(fieldName).selectize({
        delimiter: ',',
        valueField: fieldName,
        labelField: fieldName,
        searchField: searchFieldName,
        create: true,
        persist: true,
        render: {
            option: function (item, escape) {
                return '<div>' +
                    '<span class="name">' + escape(item[fieldName]) + '</span>' +
                    '</div>';
            }
        },
        load: function (query, callback) {
            if (!query.length)
                return callback();
            $.ajax({
                url: routeName,
                type: 'GET',
                dataType: 'json',
                data: {
                    search: query
                },
                error: function () {
                    callback();
                },
                success: function (res) {
                    callback(res.data);
                }
            });
        }
    });
}