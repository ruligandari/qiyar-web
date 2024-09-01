<?php $pager->setSurroundCount(2); ?>
<nav aria-label="Page navigation example">
    <ul class="pagination direction-rtl pagination-one">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<small> <?= $pager->getCurrentPageNumber() ?> dari <?= $pager->getPageCount() ?></small>