(function() {
    app.controller('createBudgetValuesCtrl', function($scope) {
        $scope.new = [];
        $scope.old = [];
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
            let $this = $(e.currentTarget);
                $deleteCheckBox = $this.closest('table')
                .find('[name*="deleted"]');

            $deleteCheckBox.prop('checked', $this.prop('checked'));
        };

        $scope.deleteBudgetValue = function(index) {
            $scope.budgetValues.splice(index, 1);
        };

        $scope.periodicityChange = function(id, type = 'old') {
            let $this = $(`[name="${type}[${id}][periodicity]"]`),
                value = $this.val(),
                showUseLength = true,
                showPayAtEnd = false;
            switch (value) {
                case 'once':
                    showUseLength = false;
                    break;
                case 'annually':
                case 'quarterly':
                    showPayAtEnd = true;
                    break;
            }

            if (!showPayAtEnd) $this.closest('tr').find('[name*="[pay_at_end]"]').prop('checked', false);
            if (!showUseLength) $this.closest('tr').find('[name*="[use_length]"]').val('');

            if('new' === type) {
                $scope.budgetValues[id].showUseLength = showUseLength;
                $scope.budgetValues[id].showPayAtEnd = showPayAtEnd;
            } else {
                $scope.old[id].showUseLength = showUseLength;
                $scope.old[id].showPayAtEnd = showPayAtEnd;
            }
        };
    })
})();