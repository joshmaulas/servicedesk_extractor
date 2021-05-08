
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Hub Declaration Summary</div>
</div>
<div class="block-content collapse in">
    <div class="span4">
        <div class="control-group">
            <label class="control-label" for="date01">Date input</label>
            <div class="controls">
                <input type="text" class="input-xlarge datepicker" id="date_for_weekly" name="datepi" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="control-group">
            <label class="control-label" for="date01">Date Range</label>
            <div class="controls">
                <select id="range">
                    <option value="weekly">Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>
        </div>
    </div>

    <div class="span3">
        <div class="control-group">
            <label class="control-label" for="">&nbsp</label>
            <div class="controls">
                <button class="btn" onclick="gen_table(this)" data-report-name='weekly_table_form' id="gene"><i class="icon-list-alt"></i> Generate</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $("input#date_for_weekly.input-xlarge.datepicker").datepicker();
    });
</script>
