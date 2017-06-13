#!/bin/bash

# Variables.
eloquent="Eloquent"
repository="Repository.php"
provider="ServiceProvider"
ext=".php"
controller="Controller"
FILE="./config/app.php"

#Reading the user input
read -p "$(tput setaf 3)Please enter the desired Module name : $(tput sgr0)" repoName

#Creates the desired Model, Service Provider and Controller.
function createRepoAndContract {
    # create Model
    php artisan make:model ${repoName^} -m

    # create Service Provider
    php artisan make:provider ${repoName^}${provider}

    # create Controller
    php artisan make:controller ${repoName^}${controller}
}
createRepoAndContract

#Creates the module related Repositories directory and
# files inside the App directory
function createRepositoryDirectory {

    mkdir ./app/Repositories 2> /dev/null
    echo "*$(tput setaf 6)Repositories directory created successfully inside the App directory.$(tput sgr0)"

    mkdir ./app/Repositories/${repoName^} && touch ./app/Repositories/${repoName^}/${repoName^}${repository} && touch ./app/Repositories/${repoName^}/${eloquent}${repoName^}${ext}
    echo "*$(tput setaf 6)Repository and Contract files created successfully.$(tput sgr0)"

}
createRepositoryDirectory


function registerServiceProvider {
    # register service provider inside config/app.php
    string='App\\Providers\\'${repoName^}${provider}'::class,'

    if [ ! -z $(grep -e "\t""$string" "$FILE") ];
    then
        echo "*$(tput setaf 6)Service Provider is already registered!$(tput sgr0)"
    else
        sed -i -e '/App\\Providers\\RouteServiceProvider::class,/a \ \t\t'${string} ${FILE} 2> /dev/null
        echo "*$(tput setaf 6)Service Provider registered successfully inside app.php of the config directory.$(tput sgr0)"
    fi
}
registerServiceProvider


function writeContractBoilerPlate {
echo "<?php

namespace App\Repositories\\${repoName^};

interface ${repoName^}Repository {
    //
}" > ./app/Repositories/${repoName^}/${repoName^}${repository}
}
writeContractBoilerPlate


function writeRepositoryBoilerPlate {
echo "<?php

namespace App\Repositories\\${repoName^};

use App\Repositories\\${repoName^}\\${repoName^}Repository;

class ${eloquent}${repoName^} implements ${repoName^}Repository {
    //
}" > ./app/Repositories/${repoName^}/${eloquent}${repoName^}${ext}
}
writeRepositoryBoilerPlate


function bindContractToRepository {
echo "<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ${repoName^}${provider} extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        \$this->app->bind('App\Repositories\\${repoName^}\\${repoName^}Repository',
            'App\Repositories\\${repoName^}\\${eloquent}${repoName^}');
    }
}" > ./app/Providers/${repoName^}${provider}.php
    if [[ $? -eq 0 ]]; then
        echo "*$(tput setaf 6)Contract and Repository binding in the Service Provider was successful.$(tput sgr0)"
    fi
}
bindContractToRepository


function controllerCrudFunctions {
echo "<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\\${repoName^}\\${repoName^}Repository;

class ${repoName^}Controller extends Controller
{
    protected \$${repoName,};

    public function __construct(${repoName^}Repository \$${repoName,}) {
        # \$this->repo = \$${repoName,};
        \$this->\$${repoName,} = \$${repoName,};
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request \$request)
    {
        //
    }

    public function show(\$id)
    {
        //
    }

    public function edit(\$id)
    {
        //
    }

    public function update(Request \$request, \$id)
    {
        //
    }

    public function delete(\$id)
    {
        //
    }
}" > ./app/Http/Controllers/${repoName^}Controller.php
}
controllerCrudFunctions