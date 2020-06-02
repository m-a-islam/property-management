<hr>
<div class="col-md-12">
    <div class="table-responsive">
        <?php if (count($flats)): ?>
        <table class="table table-bordered table-bordered table-condensed">
            <thead>
            <th>Flat</th>
            <?php for ($j = 0; $j < count($heads); $j++): ?>
                <th>
                    <?php
                    echo $heads[$j]->name;
                    ?>
                </th>
            <?php endfor; ?>
            </thead>
            <tbody>

            <?php for ($i = 0; $i < count($flats); $i++): ?>
                <tr>
                    <?php $total = 0; ?>
                    <td><?= $flats[$i]->flat_number ?></td>
                    <?php for ($j = 0; $j < count($heads); $j++): ?>
                        <td>
                            <?php $flat_rent = $this->payment_model->getFlatRent($flats[$i]->id);
                            $tenant_id = $this->payment_model->getTenantByFlat($flats[$i]->id);
                            ?>
                            <?php if ($heads[$j]->id == 6): ?>
                                <?php $total = $total + $flat_rent->flat_rent; ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="<?= $flat_rent->flat_rent ?>" readonly class="form-control">
                                <input type="hidden" name="tenant[]" value="<?= $tenant_id->id ?>" class="form-control">
                                <input type="hidden" name="flatt_id[]" value="<?= $flat_rent->id ?>"
                                       class="form-control">
                            <?php elseif ($heads[$j]->id == 5): ?>
                                <?php $total = $total + $flat_rent->gas_bill; ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="<?= $flat_rent->gas_bill ?>" readonly class="form-control">
                            <?php elseif ($heads[$j]->id == 7): ?>
                                <?php $total = $total + $flat_rent->flat_service_charge; ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="<?= $flat_rent->flat_service_charge ?>" readonly class="form-control">
                            <?php elseif ($heads[$j]->id == 9): ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="<?= $tenant_id->parking_bill ?>" readonly class="form-control">
                            <?php elseif ($heads[$j]->id == 8): ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="" class="form-control">
                            <?php elseif ($heads[$j]->id == 10): ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="" class="form-control">
                            <?php elseif ($heads[$j]->id == 11): ?>
                            <?php
                                $totalTransAdv = $this->payment_model->getAdvTransactionTable($flats[$i]->id,$tenant_id->id);//to check whether adjustable payment is greater=true or less=false then income_advance from transaction table
                                ?>
                            <?php if($totalTransAdv->canDeduct):?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="<?= $tenant_id->tenant_adv_deduct_amount?>" class="form-control">
                            <?php else:?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="" readonly class="form-control">
                            <?php endif;?>
                            <?php elseif ($heads[$j]->id == 12): ?>
                                <input type="number" name="<?= str_replace(' ', '', $heads[$j]->name) . '[]'; ?>"
                                       value="" class="form-control">
                            <?php else: ?>
                                <input type="number" class="form-control" name="restAll[]">
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>

            </tbody>
        </table>
        <div align="center">
            <input type="submit" class="btn btn-success" value="Bill Generate">
        </div>
        </form>
    </div>
    <?php else: ?>
        <div><p style="color: red">No active flats.</p></div>
    <?php endif; ?>
</div>