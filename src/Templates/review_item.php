<div class="bg-white rounded-2xl shadow-xl p-6 h-full flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-1 mb-2 text-yellow-400">
            <?php
            $note = ($review->note ?? 0);
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $note) {
                    echo '<svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z"/></svg>';
                } else {
                    echo '<svg class="w-5 h-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z"/></svg>';
                }
            }
            ?>
        </div>
        <p class="text-gray-700 italic"><?= htmlspecialchars($review->comment ?? '') ?></p>
    </div>
    <div class="mt-6 text-sm text-gray-500">
        Avis laissé par : <strong><?= htmlspecialchars($review->name ?? '') ?></strong><br>
        <span class="text-xs">
            <?php
            if (isset($review->created_at)) {
                if (is_string($review->created_at)) {
                    echo (new DateTime($review->created_at))->format('d/m/Y H:i');
                } elseif (method_exists($review->created_at, 'toDateTime')) {
                    echo $review->created_at->toDateTime()->format('d/m/Y H:i');
                }
            }
            ?>
        </span>
    </div>
</div>
