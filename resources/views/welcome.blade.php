<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8"/>
        <title>Vehicle Search</title>

        <link href="/css/style.css" rel="stylesheet" />

    </head>

    <body ng-app="myApp" ng-controller="AppCtrl"> 

        <h1>VEHICLE SEARCH</h1>

        <div class="bar">
          <input name="search" type="text" ng-model="search" ng-model-options="{ debounce: 800 }" placeholder="Search your dream car!" />
        </div>

        <table class="tblList" ng-show="items.length">
            <thead>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Badge</th>
                    <th>Variant</th>
                    <th>Colour</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="itm in items">
                    <td>[[ itm.make ]]</td>
                    <td>[[ itm.model ]]</td>
                    <td>[[ itm.badge ]]</td>
                    <td>[[ itm.variant ]]</td>
                    <td>[[ itm.color ]]</td>
                </tr>               
            </tbody>
        </table>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
        <script src="/scripts/script.js"></script>
    </body>
</html>