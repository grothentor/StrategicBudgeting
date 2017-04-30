(function() {
    app.controller('createBudgetValuesCtrl', function($scope) {
        $scope.addNewBudgetValue = function (e) {
            e.preventDefault();
            $scope.budgetValues.push({
                value: 0,
                offset: 0,
                periodicity: 'monthly',
                budget_indicator_id: null
            })
        };

        $scope.init = function($text) {
            $scope.budgetValues = JSON.parse($text);
        };

        $scope.deleteAll = function (e) {
            let $editCheckBox = $(e.currentTarget)
                .closest('table')
                .find('[name*="deleted"]');

            $editCheckBox.prop('checked', e.prop('checked'));
        };

        $scope.deleteBudgetValue = function(index) {
            $scope.budgetValues.splice(index, 1);
        };
    })
})();