This solution uses `flock` to acquire an exclusive lock on the counter file before incrementing. This ensures that only one process can modify the counter at a time, preventing race conditions.  The `flock` function is a simple, efficient solution for this specific case. For more complex scenarios, you might consider database transactions or more sophisticated locking mechanisms.

```php
<?php
$counterFile = 'counter.txt';

function incrementCounter() {
  global $counterFile;
  // Acquire an exclusive lock on the counter file
  $fp = fopen($counterFile, 'c+');
  if (!$fp) {
    return false; // Handle file opening errors
  }
  if (!flock($fp, LOCK_EX)) {
    return false; // Handle lock acquisition errors
  }

  $counter = (int)fread($fp, filesize($counterFile));
  $counter++;
  ftruncate($fp, 0); // Truncate the file
  fwrite($fp, $counter);
  flock($fp, LOCK_UN); // Release the lock
  fclose($fp);
  return $counter;
}

// Example usage
$newCounter = incrementCounter();
if ($newCounter !== false) {
  echo "Counter incremented to: " . $newCounter;
} else {
  echo "Error incrementing counter.";
}
?>
```