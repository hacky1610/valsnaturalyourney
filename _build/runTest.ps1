function Run-Tests {
    $location = Get-Location
    $PhpUnit = "$location/vendor/bin/phpunit"
    $Folder = "$location/wp-content/themes/hamzahshop/test"
    $ResultFile = "Foo.xml"

    if(!(Test-Path -Path $Folder)) {
        Write-Error "The Folder $Folder does not exist"
    }

     if(!(Test-Path -Path $PhpUnit)) {
        Write-Error "The Php Exe $PhpUnit does not exist"
    }

    Write-Output "Run tests of folder $Folder"
    $outFile = "php-unit-result.xml"

    & $PhpUnit $Folder "--log-junit" $outFile
    Convert -Source $outFile -Destination $ResultFile
}

function Convert {
    param(
        [Parameter(Mandatory)][string]$Source,
         [Parameter(Mandatory)][string]$Destination
    )

    [xml]$phpUnitTestResults = Get-Content $source
    $newXml = '<?xml version="1.0" encoding="UTF-8"?><testsuites>'
    $newXml += $phpUnitTestResults.testsuites.testsuite.InnerXml
    $newXml += '</testsuites>'
    $newXml | Out-File -filepath $destination

}