<?php
function badgeStatus($order)
{
  switch ($order->paid_status_id) {
    case 1:
      return 'bg-primary';
      break;
    case 2:
      return 'bg-info';
      break;
    case 3:
      return 'bg-danger';
      break;
    case 4:
      return 'bg-secondary';
      break;
  }
}
