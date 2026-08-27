<?php if (!empty($arrdata)) {
  foreach ($arrdata as $arrdata) { ?>
    <tr>
      <td class="text-center">
        <div class="checkbox-custom checkbox-primary">
          <input
            type="checkbox"
            name="CONTAINER_LAMA[]"
            value="<?php echo $arrdata->NO_CONT; ?>"
            id="container_<?php echo $arrdata->NO_CONT; ?>">
          <label
            for="container_<?php echo $arrdata->NO_CONT; ?>">
          </label>
        </div>
      </td>
      <td>
        <?php echo $arrdata->NO_CONT; ?>
      </td>
      <td>
        <?php echo $arrdata->UKR_CONT; ?>
      </td>
      <td>
        <?php echo $arrdata->TIPE_CONT; ?>
      </td>
    </tr>
  <?php }
} else { ?>
  <tr>
    <td colspan="4" class="text-center">
      Tidak ada container lama.
    </td>
  </tr>
<?php } ?>