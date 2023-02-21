<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test06_FilterAndSearchCest
{
    public function FilterAndSearchTest(AcceptanceTester $I): void
    {
        // auctions filter
        $I->wantTo("Test filters and search");
        $I->amOnPage('/auctions');

        $atitle1 = 'Ghost of forest';
        $astate1 = 'Good';
        $adescription1 = 'Cool game';
        $aprice1 = '50';
        $aemail1 = 'test0@gmail.com';
        $aphone1 = '793536787';
        $created_at1 = date("Y-m-d H:i:s", strtotime("-4 days"));
        $user_id1 = '1';

        $atitle2 = 'Death Winter';
        $astate2 = 'New';
        $adescription2 = 'Bought by accident';
        $aprice2 = '50';
        $aemail2 = 'test1@gmail.com';
        $aphone2 = '000111222';
        $user_id2 = '2';

        $atitle3 = 'Codenames';
        $astate3 = 'Defective';
        $adescription3 = 'Used much';
        $aprice3 = '12';
        $aemail3 = 'test2@gmail.com';
        $aphone3 = '112233445';
        $user_id3 = '3';

        $atitle4 = 'Dwergar';
        $astate4 = 'New';
        $adescription4 = 'Must sell quickly';
        $aprice4 = '30';
        $aemail4 = 'test3@gmail.com';
        $aphone4 = '793986787';
        $user_id4 = '4';

        $I->haveInDatabase('auctions', [
            'title' => $atitle1,
            'state' => $astate1,
            'description' => $adescription1,
            'price' => $aprice1,
            'email' => $aemail1,
            'phone' => $aphone1,
            'accepted' => 1,
            'created_at' => $created_at1,
            'user_id' => $user_id1
        ]);

        $I->haveInDatabase('auctions', [
            'title' => $atitle2,
            'state' => $astate2,
            'description' => $adescription2,
            'price' => $aprice2,
            'email' => $aemail2,
            'phone' => $aphone2,
            'accepted' => 1,
            'created_at' => $created_at1,
            'user_id' => $user_id2
        ]);

        $I->haveInDatabase('auctions', [
            'title' => $atitle3,
            'state' => $astate3,
            'description' => $adescription3,
            'price' => $aprice3,
            'email' => $aemail3,
            'phone' => $aphone3,
            'accepted' => 1,
            'created_at' => $created_at1,
            'user_id' => $user_id3
        ]);

        $I->haveInDatabase('auctions', [
            'title' => $atitle4,
            'state' => $astate4,
            'description' => $adescription4,
            'price' => $aprice4,
            'email' => $aemail4,
            'phone' => $aphone4,
            'accepted' => 1,
            'created_at' => $created_at1,
            'user_id' => $user_id4
        ]);

        //test on auctions page
        $I->selectOption('#state_filter', 'New');
        $I->selectOption('#price_filter', '25-50$');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see($atitle4);
        $I->dontSee($atitle1);
        $I->see($atitle2);
        $I->dontSee($atitle3);
        $I->seeOptionIsSelected('#state_filter', 'New');
        $I->seeOptionIsSelected('#price_filter', '25-50$');

        $I->selectOption('#state_filter', 'Defective');
        $I->selectOption('#price_filter', '25-50$');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see('No matching results');
        $I->dontSee($atitle4);
        $I->dontSee($atitle1);
        $I->dontSee($atitle2);
        $I->dontSee($atitle3);
        $I->seeOptionIsSelected('#state_filter', 'Defective');
        $I->seeOptionIsSelected('#price_filter', '25-50$');

        $I->selectOption('#state_filter', 'New');
        $I->selectOption('#price_filter', '25-50$');
        $I->fillField('title_filter', 'D');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see($atitle4);
        $I->see($atitle2);
        $I->dontSee($atitle1);
        $I->dontSee($atitle3);
        $I->seeOptionIsSelected('#state_filter', 'New');
        $I->seeOptionIsSelected('#price_filter', '25-50$');

        $I->selectOption('#state_filter', 'Good');
        $I->selectOption('#price_filter', '25-50$');
        $I->fillField('title_filter', 'for');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see($atitle1);
        $I->dontSee($atitle2);
        $I->dontSee($atitle3);
        $I->dontSee($atitle4);
        $I->seeInField('title_filter', 'for');
        $I->seeOptionIsSelected('#state_filter', 'Good');
        $I->seeOptionIsSelected('#price_filter', '25-50$');

        $I->amOnPage('/auctions');
        $I->see($atitle1);
        $I->see($atitle2);
        $I->see($atitle3);
        $I->see($atitle4);

        // games filter
        $I->amOnPage('/library');
        $I->selectOption('#category_filter', 'Strategy');
        $I->selectOption('#time_filter', '0-30 Min');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->dontSee('Anachrony');
        $I->dontSee('Monopoly');
        $I->dontSee('Codenames');
        $I->dontSee('Cluedo');
        $I->see('Patchwork');
        $I->seeOptionIsSelected('#category_filter', 'Strategy');
        $I->seeOptionIsSelected('#time_filter', '0-30 Min');

        $I->fillField('title_filter', 'on');
        $I->selectOption('#category_filter', 'Strategy');
        $I->selectOption('#time_filter', '90-120 Min');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see('Anachrony');
        $I->dontSee('Monopoly');
        $I->dontSee('Codenames');
        $I->dontSee('Cluedo');
        $I->dontSee('Patchwork');
        $I->seeInField('title_filter', 'on');
        $I->seeOptionIsSelected('#category_filter', 'Strategy');
        $I->seeOptionIsSelected('#time_filter', '90-120 Min');

        $I->fillField('players_filter', '2');
        $I->selectOption('#category_filter', 'Strategy');
        $I->selectOption('#time_filter', '90-120 Min');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->see('Anachrony');
        $I->dontSee('Monopoly');
        $I->dontSee('Codenames');
        $I->dontSee('Cluedo');
        $I->dontSee('Patchwork');
        $I->seeInField('players_filter', '2');
        $I->seeOptionIsSelected('#category_filter', 'Strategy');
        $I->seeOptionIsSelected('#time_filter', '90-120 Min');

        $I->fillField('title_filter', '');
        $I->fillField('players_filter', '2');
        $I->selectOption('#category_filter', 'Strategy');
        $I->selectOption('#time_filter', '0-30 Min');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->dontSee('Anachrony');
        $I->dontSee('Monopoly');
        $I->dontSee('Codenames');
        $I->dontSee('Cluedo');
        $I->see('Patchwork');
        $I->seeInField('players_filter', '2');
        $I->seeOptionIsSelected('#category_filter', 'Strategy');
        $I->seeOptionIsSelected('#time_filter', '0-30 Min');

        $I->fillField('title_filter', 'luedo');
        $I->fillField('players_filter', '4');
        $I->selectOption('#category_filter', 'Murder/Mystery');
        $I->selectOption('#time_filter', '30-60 Min');
        $I->click(['id'=> 'filter']);
        $I->seeInTitle('Filter results');
        $I->dontSee('Anachrony');
        $I->dontSee('Monopoly');
        $I->dontSee('Codenames');
        $I->see('Cluedo');
        $I->dontSee('Patchwork');
        $I->seeInField('players_filter', '4');
        $I->seeInField('title_filter', 'luedo');
        $I->seeOptionIsSelected('#category_filter', 'Murder/Mystery');
        $I->seeOptionIsSelected('#time_filter', '30-60 Min');

        // searchbar
        $title1 = "Fury of Dracula";
        $category1 = 'Horror';
        $description1 = 'Classic horror deduction game.';
        $year1 = 2015;
        $time1 = 180;
        $players1 = '2-5';

        $title2 = "Eldritch Horror";
        $category2 = 'Horror';
        $description2 = 'Cooperative game of Lovecraft horror.';
        $year2 = 2013;
        $time2 = 240;
        $players2 = '1-8';

        $title3 = "Spirit Island";
        $category3 = 'Fantasy';
        $description3 = 'Complex and thematic cooperative game about defending your island home from colonizing Invaders.';
        $year3 = 2017;
        $time3 = 120;
        $players3 = '1-4';

        $title4 = "Spirits of the Forest";
        $category4 = 'Strategy';
        $description4 = 'Players represent the four elements that nourish the forces of nature.';
        $year4 = 2018;
        $time4 = 20;
        $players4 = '1-4';

        $title5 = "Ramen Fury";
        $category5 = 'Cards';
        $description5 = 'Rush to prepare and slurp up delicious bowls of ramen filled with tasty ingredients.';
        $year5 = 2019;
        $time5 = 30;
        $players5 = '2-5';

        $I->haveInDatabase('games', [
            'title' => $title1,
            'category' => $category1,
            'description' => $description1,
            'year' => $year1,
            'time' => $time1,
            'players' => $players1,
            'accepted' => 1,
            'created_at' => $created_at1
        ]);

        $I->haveInDatabase('games', [
            'title' => $title2,
            'category' => $category2,
            'description' => $description2,
            'year' => $year2,
            'time' => $time2,
            'players' => $players2,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-3 days"))
        ]);

        $I->haveInDatabase('games', [
            'title' => $title3,
            'category' => $category3,
            'description' => $description3,
            'year' => $year3,
            'time' => $time3,
            'players' => $players3,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-2 days"))
        ]);

        $I->haveInDatabase('games', [
            'title' => $title4,
            'category' => $category4,
            'description' => $description4,
            'year' => $year4,
            'time' => $time4,
            'players' => $players4,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s", strtotime("-1 days"))
        ]);

        $I->haveInDatabase('games', [
            'title' => $title5,
            'category' => $category5,
            'description' => $description5,
            'year' => $year5,
            'time' => $time5,
            'players' => $players5,
            'accepted' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        $I->fillField(['id'=>'search'], 'Robinson Crusoe');
        $I->click(['id'=>'search_main']);
        $I->seeInTitle('Search results');
        $I->see('Empty search');

        $I->amOnPage('/library');
        $I->fillField(['id'=>'search'], $title1);
        $I->click(['id'=>'search_main']);
        $I->seeInTitle('Search results');
        $I->seeCurrentUrlEquals('/search?search=Fury+of+Dracula');
        $I->see($title1);
        $I->dontSee($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);
        $I->dontSee($title5);
        $I->seeInField(['id'=>'search'], $title1);

        $I->amOnPage('/');
        $I->fillField('#search', 'fury');
        $I->click('#search_main');
        $I->seeInTitle('Search results');
        $I->seeCurrentUrlEquals('/search?search=fury');
        $I->see($title1);
        $I->see($title5);
        $I->dontSee($title2);
        $I->dontSee($title3);
        $I->dontSee($title4);
        $I->seeInField(['id'=>'search'], 'fury');

        $I->amOnPage('/library');
        $I->click('#search_main');
        $I->dontSeeInTitle('Search results');
        $I->seeInTitle('Library');
        $I->seeCurrentUrlEquals('/search?search=');
        $I->see($title1);
        $I->see($title5);
        $I->see($title2);
        $I->see($title3);
        $I->see($title4);
    }
}
