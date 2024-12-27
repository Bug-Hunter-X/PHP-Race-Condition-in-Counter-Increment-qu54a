# PHP Race Condition in Counter Increment

This repository demonstrates a race condition in a simple PHP counter increment function and provides a solution. The bug occurs when multiple requests attempt to increment the counter concurrently, leading to inaccurate results. The solution utilizes file locking to ensure atomicity and prevent race conditions.