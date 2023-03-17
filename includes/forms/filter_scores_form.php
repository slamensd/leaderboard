<fieldset>
<div class="form-group col-md-5">
    	<label for="game"><?php echo $lang['form-game']; ?></label>
    	<select id="game" name="game" placeholder="" class="form-control form-control-sm" >
            <?php foreach ($table_scoreboards as $key=>$table) { ?>
            <option value="<?php echo $table['id']; ?>" <?php echo ($edit && $table['id'] == $filterScores['game']) ? "selected": "" ; ?>><?php echo $table['name']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-5">
        <label for="type"><?php echo $lang['form-category']; ?></label>
        <input type="type" name="type" value="<?php echo $edit ? $filterScores['type'] : ''; ?>" placeholder="" class="form-control form-control-sm" id="type">
    </div>

    <div class="form-group col-md-5">
        <label for="score_min"><?php echo $lang['form-score-min']; ?></label>
        <input type="number" name="score_min" value="<?php echo $edit ? $filterScores['score_min'] : ''; ?>" placeholder="" class="form-control form-control-sm" id="score_min">
    </div>

    <div class="form-group col-md-5">
        <label for="score_max"><?php echo $lang['form-score-max']; ?></label>
        <input type="number" name="score_max" value="<?php echo $edit ? $filterScores['score_max'] : ''; ?>" placeholder="" class="form-control form-control-sm" id="score_max">
    </div>

    <div class="form-group col-md-5">
    	<label for="status"><?php echo $lang['form-active-status']; ?></label>
    	<select id="status" name="status" placeholder="" class="form-control form-control-sm" >
            <option value="1" <?php echo ($edit && $filterScores['status'] == '1') ? "selected": "" ; ?>><?php echo $lang['option-active']; ?></option>        
            <option value="0" <?php echo ($edit && $filterScores['status'] == '0') ? "selected": "" ; ?>><?php echo $lang['option-inactive']; ?></option>
        </select>
    </div>

    <div class="form-group col-md-5">
        <label></label>
        <button type="submit" class="btn btn-success btn-sm" ><span class="fa fa-save fa-fw"></span> <?php echo $lang['button-save-score']; ?></button>
        <a href="filter_scores.php" class="btn btn-secondary btn-sm" ><span class="fa fa-times fa-fw"></span> <?php echo $lang['button-cancel']; ?></a>
    </div>            
</fieldset>