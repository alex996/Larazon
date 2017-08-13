<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\GeoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeoRepositoryTest extends TestCase
{
    protected $geo;

    public function setUp()
    {
        parent::setUp();

        $this->geo = $this->app->make(GeoRepository::class);
    }

    /*******************************************************************
    **************************** COUNTRIES *****************************
    *******************************************************************/

    public function testItReturnsCountryNameGivenItsCode()
    {
        // Given
        $countryCodeCA = 'CA';
        $countryCodeUS = 'US';
        // When
        $countryNameCA = $this->geo->getCountryName($countryCodeCA);
        $countryNameUS = $this->geo->getCountryName($countryCodeUS);
        // Then
        $this->assertEquals($countryNameCA, 'Canada');
        $this->assertEquals($countryNameUS, 'United States of America');
    }

    public function testItReturnsCountryCodes()
    {
        // Given
        $expectedCountryCodes = ['US', 'CA'];
        // When
        $countryCodes = $this->geo->getCountryCodes();
        // Then
        $this->assertEquals($countryCodes, $expectedCountryCodes);
    }

    public function testItReturnsCountryCodesSeparatedByCommas()
    {
        // Given
        $expectedCountryCodes = 'US,CA';
        // When
        $countryCodes = $this->geo->getCountryCodesWithCommas();
        // Then
        $this->assertEquals($countryCodes, $expectedCountryCodes);
    }

    /*******************************************************************
    ****************************** STATES ******************************
    *******************************************************************/

    public function testItReturnsStatesForAGivenCountry()
    {
        // Given
        $countryCode = 'CA';
        $expectedStates = $this->geo->getStatesByCountry()[$countryCode];
        // When
        $states = $this->geo->getStates($countryCode);
        // Then
        $this->assertEquals($expectedStates, $states);
    }

    public function testItReturnsStateNameGivenItsCode()
    {
        // Given
        $stateCodeUT = 'UT';
        $stateCodeSK = 'SK';
        // When
        $stateNameUT = $this->geo->getStateName($stateCodeUT);
        $stateNameSK = $this->geo->getStateName($stateCodeSK);
        // Then
        $this->assertEquals($stateNameUT, 'Utah');
        $this->assertEquals($stateNameSK, 'Saskatchewan');
    }

    public function testItReturnsStateCodesForAGivenCountry()
    {
        // Given
        $countryCode = 'CA';
        $expectedStateCodes = ['AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'];
        // When
        $stateCodes = $this->geo->getStateCodes($countryCode);
        // Then
        $this->assertEquals($stateCodes, $expectedStateCodes);
    }

    public function testItReturnsStateCodesSeparatedByCommas()
    {
        // Given
        $countryCode = 'CA';
        $expectedStateCodes = 'AB,BC,MB,NB,NL,NS,NT,NU,ON,PE,QC,SK,YT';
        // When
        $stateCodes = $this->geo->getStateCodesWithCommas($countryCode);
        // Then
        $this->assertEquals($stateCodes, $expectedStateCodes);
    }
}
