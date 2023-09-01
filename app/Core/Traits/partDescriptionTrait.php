<?php

namespace App\Core\Traits;

use App\Models\Part;
use App\Models\Option;

trait partDescriptionTrait
{
    public function appendDescriptionLength($part_id, $length)
    {

        // getting part description and cat
        $partDB = Part::find($part_id, ['id', 'category_id', 'desc']);
        $dbDesc = $partDB['desc'];
        // getting parent category from options table
        $category = Option::find($partDB['category_id'], 'p_id');
        $updatedDesc = $dbDesc;
        // check string length count
        $count = strlen($length);
        if ($count < 3) {
            // check if parent id is from one of them && the subcategory is not adjustable id=19
            $aletredDesc = $dbDesc;
            $periodCount = substr_count($dbDesc, '.');
            // p_id 1 parent_category Anklets
            // p_id 3 parent_category Bracelets
            // p_id 5 parent_category Earring and Pendant Sets
            // p_id 8 parent_category Hoops
            // p_id 10 parent_category Necklace Sets
            // p_id 11 parent_category Necklaces
            // p_id 15 parent_category Rosaries
            // p_id 3 parent_category Bracelets  (subcategory id=29 name = Adjustable)
            if (($category['p_id'] == 1  || $category['p_id'] == 3  || $category['p_id'] == 5 || $category['p_id'] == 8 || $category['p_id'] == 10 || $category['p_id'] == 11 || $category['p_id'] == 15) && ($partDB['category_id'] != 29)) {
                //count number of periods in description
                if ($periodCount > 2) {
                    $aletredDesc = substr($dbDesc, 0, -3);
                }
                // check if parent cat is one digit then extend 0 before
                if ($count == 1) {
                    $updatedDesc = $aletredDesc . '.0' . $length;
                }
                // check if parent cat length 2 then skip period
                if ($count == 2) {
                    $updatedDesc = $aletredDesc . '.' . $length;
                }

                // check if the updated and dbpart description is same then don't update
                if ($dbDesc != $updatedDesc) {
                    Part::find($part_id)->update(['desc' => $updatedDesc]);
                }
            } elseif ($partDB['category_id'] == 29) {
                if ($periodCount == 3) {
                    $aletredDesc = substr($dbDesc, 0, -3);
                    $updatedDesc = $aletredDesc;
                    Part::find($part_id)->update(['desc' => $updatedDesc]);
                }
            }
        }
        return $updatedDesc;
    }

    public function appendDescriptionSize($part_id, $ringSize, $bangleSize)
    {
        $data['ring_size'] = $ringSize;
        $data['bangle_size'] = $bangleSize;
        // 14 category ring 
        // 2 category bangles 
        if (isset($data['ring_size']) || isset($data['bangle_size'])) {
            // getting part description and cat
            $partDB = Part::find($part_id, ['id', 'category_id', 'desc']);
            $updatedDesc = $partDB['desc'];
            // getting parent category from options table
            $category = Option::find($partDB['category_id'], 'p_id');
            if ($category['p_id'] == 2 || $category['p_id'] == 14) {
                $dbDesc = $partDB['desc'];
                $aletredDesc = $partDB['desc'];
                if (isset($data['bangle_size'])) {
                    if ($data['bangle_size'] != 513) {
                        $bangleRecord = Option::find($data['bangle_size']);
                        $bangleRecord['name_in_english'] = explode(' ', $bangleRecord['name_in_english']);
                        $size = $bangleRecord['name_in_english'][1];
                        $count = strlen($size);
                        $periodCount = substr_count($dbDesc, '.');
                        if ($periodCount > 2) {
                            $aletredDesc = substr($dbDesc, 0, -3);
                        }
                        if ($count == 1) {
                            $updatedDesc = $aletredDesc . '.0' . $size;
                        }
                        if ($count == 2) {
                            $updatedDesc = $aletredDesc . '.' . $size;
                        }
                        Part::find($part_id)->update(['desc' => $updatedDesc]);
                    } elseif ($data['bangle_size'] == 513) {
                        $periodCount = substr_count($dbDesc, '.');
                        if ($periodCount == 3) {
                            $aletredDesc = substr($dbDesc, 0, -3);
                            $dbDesc = $aletredDesc;
                            Part::find($part_id)->update(['desc' => $dbDesc]);
                        }
                    }
                }
                //  ring sizes 
                // 14 categoty rings 89 subcategory toe
                if (isset($data['ring_size'])) {
                    if ($data['ring_size'] != 521 && $partDB['category_id'] != 89) {
                        $ringRecord = Option::find($data['ring_size']);
                        $ringRecord['name_in_english'] = str_replace('Ring Size ', '', $ringRecord['name_in_english']);
                        $size = trim($ringRecord['name_in_english']);
                        $count = strlen($size);
                        $periodCount = substr_count($dbDesc, '.');

                        if ($periodCount > 2) {
                            $aletredDesc = substr($dbDesc, 0, -3);
                        }
                        if ($count == 1) {
                            $updatedDesc = $aletredDesc . '.0' . $size;
                        }
                        if ($count == 2) {
                            $updatedDesc = $aletredDesc . '.' . $size;
                        }
                        Part::find($part_id)->update(['desc' => $updatedDesc]);
                    } elseif ($data['ring_size'] == 521 || $partDB['category_id'] == 89) {
                        $periodCount = substr_count($dbDesc, '.');
                        if ($periodCount == 3) {
                            $aletredDesc = substr($dbDesc, 0, -3);
                            $dbDesc = $aletredDesc;
                            Part::find($part_id)->update(['desc' => $dbDesc]);
                        }
                    }
                }
            }
            return $updatedDesc;
        }
    }
}
