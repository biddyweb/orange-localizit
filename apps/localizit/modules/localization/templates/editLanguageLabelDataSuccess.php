<?php if ($languageLabelDataSet) { ?>
    <form method="post" name="editLanguageLabelList" action="<?php echo url_for('localization/index'); ?>" id="editLanguageLabelList">
        <table class="mainFrame  mediumText">
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <td class="boldText">Label</td>
                    <td class="boldText">Source Language (<?php echo $sourceLanguageLabel ?>)</td>
                    <td class="boldText">Target Language (<?php echo $targetLanguageLabel ?>)</td>
                    <td class="boldText">Language Group</td>
                    <td class="boldText">Comments</td>
                    <td class="addDotLinetoRight">&nbsp;</td>
                </tr>
            </thead>
            <tbody>
            <?php $role = sfContext::getInstance()->getUser()->getUserRole(); ?>

            <?php foreach ($languageLabelDataSet as $labelId => $languageLabelData) { ?>
            <?php $labelInnerData = $languageLabelData->get($labelId); ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="text" name="label_name[]" value="<?php echo isset($labelInnerData['label_name']) ? $labelInnerData['label_name'] : null ?>" class="text_input" <?php if (!$role->isAllowedToAddLabel()) { ?>readonly style="background-color: #CCC"<?php } ?>/>
                        <input type="hidden" name="label_id[]" value="<?php echo isset($labelInnerData['label_id']) ? $labelInnerData['label_id'] : null ?>"/>
                    </td>
                    <td>
                        <input type="text" name="source_language_string[]" value="<?php echo isset($labelInnerData['source_language_label']) ? $labelInnerData['source_language_label'] : null ?>" class="text_input" <?php if (!$role->isAllowedToAddLabel()) { ?>readonly style="background-color: #CCC"<?php } ?>/>
                        <input type="hidden" name="source_language_string_id[]" value="<?php echo isset($labelInnerData['source_language_label_string_id']) ? $labelInnerData['source_language_label_string_id'] : null ?>"/>
                    </td>
                    <td>
                        <input type="text" name="target_language_string[]" value="<?php echo isset($labelInnerData['target_language_label']) ? $labelInnerData['target_language_label'] : null ?>" class="text_input" <?php if (!in_array($targetLanguageId, $role->getAllowedLanguageList())) { ?>readonly style="background-color: #CCC"<?php } ?>/>
                        <input type="hidden" name="target_language_string_id[]" value="<?php echo isset($labelInnerData['target_language_label_string_id']) ? $labelInnerData['target_language_label_string_id'] : null ?>"/>
                    </td>
                    <td>
                        <select class="langueDropDownList" name="language_group_id[]" <?php if (!$role->isAllowedToAddLabel()) { ?> disabled="disabled" style="background-color: #CCC"<?php } ?>>
                            <?php foreach ($lanagueGroupList as $langGroup) { ?>
                                        <option value="<?php echo $langGroup->getId() ?>" <?php echo $labelInnerData['language_group_id']==$langGroup->getId() ? 'selected="selected"':null?> >
                                            <?php echo  $langGroup->getGroupName() ?>
                                        </option>
                            <?php } ?>
                                        <?php if (!$role->isAllowedToAddLabel()) { ?>
                                            <input type="hidden" name="language_group_id[]" value="<?php echo  $labelInnerData['language_group_id'] ?>" />
                                        <?php } ?>
                        </select>

                    </td>
                    <td>
                        <textarea cols="30" rows="2" name="label_comment[]" class="text_input"><?php echo isset($labelInnerData['comment']) ? $labelInnerData['comment'] : null ?></textarea>
                    </td>
                    <td class="addDotLinetoRight">&nbsp;</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <input type="hidden" id="target_language_selected_id" name="target_language_selected_id" />
</form>
<?php } ?>