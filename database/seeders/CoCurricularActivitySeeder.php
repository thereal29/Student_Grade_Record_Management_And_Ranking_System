<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CoCurricularType;
use App\Models\CoCurricularSubType;
use App\Models\CoCurricularAwardScope;
use App\Models\CoCurricular;
class CoCurricularActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = CoCurricularType::create([
            'type_of_activity' => 'Participation',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'International',
            'point' => '5',
            'parentID' => '1',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'National',
            'point' => '4',
            'parentID' => '1',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Regional',
            'point' => '3',
            'parentID' => '1',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Division',
            'point' => '2',
            'parentID' => '1',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Local',
            'point' => '1',
            'parentID' => '1',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'First',
            'point' => '5',
            'parentID' => '1',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Second',
            'point' => '4',
            'parentID' => '1',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Third',
            'point' => '3',
            'parentID' => '1',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Fourth',
            'point' => '2',
            'parentID' => '1',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Fifth',
            'point' => '1',
            'parentID' => '1',
        ]);
        $type = CoCurricularType::create([
            'type_of_activity' => 'Organization and Designation',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'President',
            'point' => '5',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Vice President',
            'point' => '4',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Treasurer',
            'point' => '4',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Secretary',
            'point' => '3',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Senator',
            'point' => '3',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Representative',
            'point' => '2',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Auditor',
            'point' => '2',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'SK',
            'point' => '1',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Sgt.@Arms',
            'point' => '1',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Muse',
            'point' => '1',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Prince Charming',
            'point' => '1',
            'parentID' => '2',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Monitor',
            'point' => '1',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'International',
            'point' => '5',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'National',
            'point' => '4',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Regional',
            'point' => '3',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Division',
            'point' => '2',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Chapter',
            'point' => '1',
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Class/Sub-Chapter',
            'point' => 0.75,
            'parentID' => '2',
        ]);
        $awardScope = CoCurricularAwardScope::create([
            'award_scope' => 'Section',
            'point' => 0.5,
            'parentID' => '2',
        ]);
        $type = CoCurricularType::create([
            'type_of_activity' => 'Publication',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Editor-in-Chief',
            'point' => '5',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Associate Editor',
            'point' => '4',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Business Manager',
            'point' => '3',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'News',
            'point' => '2',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Feature',
            'point' => '2',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Circulation',
            'point' => '2',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Reporter',
            'point' => '1',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Photographer',
            'point' => '1',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Contributor',
            'point' => '1',
            'parentID' => '3',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Staff',
            'point' => '1',
            'parentID' => '3',
        ]);
        $type = CoCurricularType::create([
            'type_of_activity' => 'Sports',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'General Athletic Manager (GAM)',
            'point' => '5',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Most Valuable Player (MVP)',
            'point' => '5',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Assistant GAM',
            'point' => '4',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Coach',
            'point' => '4',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Treasurer',
            'point' => '4',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Secretary',
            'point' => '4',
            'parentID' => '4',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Secretariat',
            'point' => '4',
            'parentID' => '4',
        ]);
        $type = CoCurricularType::create([
            'type_of_activity' => 'CAT',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Corps Commander',
            'point' => '5',
            'parentID' => '5',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Battalion Staff',
            'point' => '4',
            'parentID' => '5',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Company Commander',
            'point' => '3',
            'parentID' => '5',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Platoon Leader',
            'point' => '2',
            'parentID' => '5',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Battalion Sgt.',
            'point' => '1',
            'parentID' => '5',
        ]);
        $subtype = CoCurricularSubType::create([
            'subtype' => 'Sponsor/Escort',
            'point' => '1',
            'parentID' => '5',
        ]);

        $coCurricularList = CoCurricularType::select('cocurricular_activity_type.id AS tid','cocurricular_activity_subtype.id AS stid', 'cocurricular_activity_award_scope.id AS asid', 'cocurricular_activity_type.type_of_activity', 'cocurricular_activity_subtype.subtype', 'cocurricular_activity_subtype.point AS subtype_point', 'cocurricular_activity_award_scope.award_scope', 'cocurricular_activity_award_scope.point AS award_scope_point')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.parentID', '=', 'cocurricular_activity_type.id')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.parentID', '=', 'cocurricular_activity_type.id')->get();
        foreach($coCurricularList as $activity){
            $coCurricular = CoCurricular::create([
                'typeID' => $activity->tid,
                'subtypeID' => $activity->stid,
                'award_scopeID' => $activity->asid,
            ]);
        }
    }
}
