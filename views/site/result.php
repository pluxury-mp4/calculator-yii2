
<div class="row">
    <div class="col-md-5 mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                Введенные данные:
                <?php foreach ($model->getAttributes() as $key => $attribute): ?>
                    <div>
                        <?= $model->getAttributeLabel($key) ?>: <strong><?= $attribute ?></strong>
                    </div>
                <?php endforeach ?>
                <div>
                    Итог, руб. :
                    <strong> <?= $repository->getPriceFromDb($model->raw_type, $model->month, $model->tonnage) ?> </strong>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <th>
            Месяц/Тоннаж
        </th>
        <?php
        foreach ($repository->getTonnagesListFromDb() as $tonnages):?>
            <th>
                <?= $tonnages ?>
            </th>
        <?php endforeach ?>
        </thead>
        <tbody>
        <?php foreach ($repository->getMonthsListFromDb() as $month): ?>
            <tr>
                <td>
                    <?= $month ?>
                </td>
                <?php foreach ($repository->getPriceArrayFromDb($model->raw_type, $month) as $price): ?>
                    <td>
                        <?= $price ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach;
        ?>
        </tbody>
    </table>
</div>
</fieldset>
</div>
</div>