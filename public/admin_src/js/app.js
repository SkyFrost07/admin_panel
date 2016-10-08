angular.module('ngFile', [])
        .config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('{%');
            $interpolateProvider.endSymbol('%}');
        })
        .controller('FileCtrl', function ($scope, $rootScope, $http) {
            $rootScope.files = [];
            $scope.loadFiles = function (multi_check) {
                if ($rootScope.files.length === 0) {
                    $rootScope.multi_check = multi_check;
                    $http.get(files_url, {
                        params: {'fields[]': ['id', 'rand_dir', 'url']}
                    }).then(function (response) {
                        $rootScope.files = response.data.data;
                    }).catch(function (err) {
                        console.log(err);
                    });
                }
            };

            $scope.checked_files = [];

            $scope.inCheckedFiles = function (item) {
                for (var i in $scope.checked_files) {
                    if ($scope.checked_files[i].id == item.id) {
                        return true;
                    }
                }
                return false;
            };

            $scope.findFileIndex = function (file) {
                for (var i in $scope.checked_files) {
                    if ($scope.checked_files[i].id == file.id) {
                        return i;
                    }
                }
                return -1;
            };

            $scope.checkFile = function (file, multi) {
                $scope.proccessing = false;
                if (typeof multi == "undefined") {
                    multi = false;
                }

                var index = $scope.findFileIndex(file);
                if (index > -1) {
                    $scope.checked_files.splice(index, 1);
                } else {
                    if (multi) {
                        $scope.checked_files.push(file);
                    } else {
                        $scope.checked_files = [];
                        $scope.checked_files[0] = file;
                    }
                }
            };

            $scope.submitChecked = function () {
                $scope.submit_files = $scope.checked_files;
                var modal = jQuery('#files_modal');
                modal.modal('hide');
            };

            $scope.removeFile = function (file) {
                var index = $scope.submit_files.indexOf(file);
                $scope.submit_files.splice(index, 1);
            };
        })
        .directive('ngThumb', function ($http, $timeout) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    attrs.$observe("fileId", function (file_id) {
                        $timeout(function () {
                            var size = attrs.ngThumb;
                            $http.get(files_url + '/' + file_id, {
                                params: {size: size},
                                headers: {_token: _token}
                            }).then(function (response) {
                                element.html(response.data);
                            });
                        }, 200);
                    });
                }
            };
        })
        .directive('fileUpload', function ($http, $rootScope) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    element.bind('change', function (event) {
                        scope.$apply(function () {
                            var files = event.target.files || event.dataTransfer.files;
                            var formData = new FormData();
                            for (var i = 0; i < files.length; i++) {
                                formData.append('files[]', files[i]);
                            }
                            formData.append('_token', _token);
                            $http({
                                method: 'POST',
                                url: '/' + current_locale + '/manage/files',
                                data: formData,
                                headers: {'Content-type': undefined}
                            }).success(function (data) {
                                $rootScope.files = data.concat($rootScope.files);
                                $('#input_files').val('');
                                $('a[href="#tab_select_files"]').click();
                            }).error(function (error) {
                                console.log(error);
                            });
                        });
                    });
                }
            };
        });



