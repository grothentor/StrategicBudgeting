(function() {
    app.controller('createBudgetValuesCtrl', function($scope) {
        $scope.budgetValues = [];
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

        $scope.changeValueType = function (e) {
            let hiddenClass = 'hidden',
                $row = $(e.currentTarget).closest('tr'),
                $valueHolder = $row.find('.value-holder'),
                $byCountHolders = $row.find('.by-count-holder');

            if (!$valueHolder.hasClass(hiddenClass)) {
                let newId;
                if (newId = $row.attr('data-new-id')) {
                    $scope.budgetValues[newId].dataValue = $scope.budgetValues[newId].value;
                    $scope.budgetValues[newId].value = '';

                    if (void 0 !== $scope.budgetValues[newId].dataSingularValue) {
                        $scope.budgetValues[newId].singular_value = $scope.budgetValues[newId].dataSingularValue;
                        $scope.budgetValues[newId].count = $scope.budgetValues[newId].dataCount;
                    }
                } else {
                    let $value = $valueHolder.find('input');
                    $valueHolder.attr('data-old-data', $value.val());
                    $value.val('');

                    $byCountHolders.each(function () {
                        let $this = $(this);
                        $this.find('input').val($this.data('old-data'));
                    });
                }
            } else {
                let newId;
                if (newId = $row.attr('data-new-id')) {
                    $scope.budgetValues[newId].dataSingularValue = $scope.budgetValues[newId].singular_value;
                    $scope.budgetValues[newId].dataCount = $scope.budgetValues[newId].count;
                    $scope.budgetValues[newId].singular_value = '';
                    $scope.budgetValues[newId].count = '';

                    if (void 0 !== $scope.budgetValues[newId].value) {
                        $scope.budgetValues[newId].value = $scope.budgetValues[newId].dataValue;
                    }
                } else {
                    $valueHolder.find('input').val($valueHolder.data('old-data'));
                    $byCountHolders.each(function () {
                        let $this = $(this);
                        let $value = $this.find('input');
                        $this.attr('data-old-data', $value.val());
                        $value.val('');
                    });
                }
            }
            $valueHolder.toggleClass(hiddenClass);
            $byCountHolders.toggleClass(hiddenClass);
        }
    })
})();