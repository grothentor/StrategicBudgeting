(function() {
    $(document).on('change', '.budgets-values-table input, .budgets-values-table select', function(e) {
        let $editCheckBox = $(e.currentTarget)
            .closest('tr')
            .find('[name*="edited"]');

        $editCheckBox.val(1);
    });
})();