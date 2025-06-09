<?php include VIEW . '/components/header.php'; ?>

<h2>Istoric inputuri generate</h2>

<?php if (empty($items)): ?>
  <p>Nu ai generat încă niciun input.</p>
<?php else: ?>
  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>Tip</th>
        <th>Conținut</th>
        <th>Data</th>
        <th>Export</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['type']) ?></td>
          <td style="white-space: pre-wrap;">
            <?= htmlspecialchars(json_encode(json_decode($item['content']))) ?>
          </td>
          <td><?= htmlspecialchars($item['created_at']) ?></td>
          <td>
            <a href="/PIG/public/export?id=<?= $item['id'] ?>&format=json" target="_blank">JSON</a> |
            <a href="/PIG/public/export?id=<?= $item['id'] ?>&format=csv" target="_blank">CSV</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php include VIEW . '/components/footer.php'; ?>
