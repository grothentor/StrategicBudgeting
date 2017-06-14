(function() {
    $(document).on('change', '.budgets-values-table input, .budgets-values-table select', function(e) {
        let $editCheckBox = $(e.currentTarget)
            .closest('tr')
            .find('[name*="edited"]');

        $editCheckBox.val(1);
    });
    $('.select2').select2({ width: 'element' });
    $('.print-link').on('click', function (event) {
        event.preventDefault();
        window.open($(event.currentTarget).attr('href'), '_blank');
    });
})();