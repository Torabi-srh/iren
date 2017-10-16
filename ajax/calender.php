<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");

$events_ = array();
$_events = array();

if (isset($_POST['eventsJson'])) $_events = json_decode($_POST['eventsJson'], true); else die();
foreach ($_events as $val) {
  if (is_array($val) || is_object($val)) {
    $events_[] = new Event($val); //die();
    foreach ($_events[0]['source']['events'] as $key) {
      if (is_array($key) || is_object($key)) {
        $events_[] = new Event($key); //die();
      } else {continue;}
    }break;
  } else {continue;}
}
$title = "";
$allDay = ""; // a boolean
$start = ""; // a DateTime
$end = ""; // a DateTime, or null
$properties = array(); // an array of other misc properties
// sabtshode => {}
// reserve => ||
// cleaning events
foreach ($events_ as $insider) {
  if (empty($insider) || $insider == '') continue;
  foreach ($events_ as $outsider) {
    if (empty($outsider) || $outsider == '') continue;
    if($outsider === $insider) continue;
    if ($insider->isWithinDayRange($outsider->start, $outsider->end)) {
      if ($outsider->start === $insider->start) {
        if ($outsider->end === $insider->end) {
          if ($insider->title === 'ساعت ثبت شده') {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {{   }}
              $outsider = '';
              continue;
            } else {
              // |{   }|
              $outsider = '';
              continue;
            }
          } else {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {|   |}
              $insider = '';
              break;
            } else {
              // ||   ||
              $outsider = '';
              continue;
            }
          }
        } else {
          if ($insider->title === 'ساعت ثبت شده') {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {{   }  }
              $insider = '';
              break;
            } else {
              // |{   }   |
              $outsider->start = $insider->end;
              continue;
            }
          } else {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {|   |   }
              $insider = '';
              break;
            } else {
              // ||   |   |
              $insider = '';
              break;
            }
          }
        }
      } else {
        if ($outsider->end === $insider->end) {
          if ($insider->title === 'ساعت ثبت شده') {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {   {   }}
              $insider = '';
              break;
            } else {
              // |   {   }|
              $outsider->end = $insider->start;
              continue;
            }
          } else {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {   |   |}
              $insider = '';
              break;
            } else {
              // |   |   ||
              $insider = '';
              break;
            }
          }
        } else {
          if ($insider->title === 'ساعت ثبت شده') {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {   {     }    }
              $insider = '';
              break;
            } else {
              // |   {     }    |
              $events__ = new Event($outsider);
              $events__->start = $insider->end;
              $outsider->end = $insider->start;
              $events_[] = $events__;
              continue;
            }
          } else {
            if ($outsider->title === 'ساعت ثبت شده') {
              // {   |     |    }
              $insider = '';
              break;
            } else {
              // |   |     |    |
              $insider = '';
              break;
            }
          }
        }
      }
    } else {
      // NOT INSIDE
      if ($insider->start == $outsider->start && $insider->end !== $outsider->end) {
        if ($insider->title === 'ساعت ثبت شده') {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {[   }   ]
            if ($insider->end > $outsider->end) {
              $outsider = '';
              continue;
            } else {
              $insider = '';
              break;
            }
          } else {
            // |{   |   }
            if ($insider->end > $outsider->end) {
              $outsider = '';
              continue;
            } else {
              $outsider->start = $insider->end;
              continue;
            }
          }
        } else {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {|     }    |
            if ($insider->end > $outsider->end) {
              $insider->start = $outsider->end;
              continue;
            } else {
              $insider = '';
              break;
            }
          } else {
            // |/     |    /
            if ($insider->end > $outsider->end) {
              $outsider = '';
              continue;
            } else {
              $insider = '';
              break;
            }
          }
        }
      } elseif ($insider->start !== $outsider->start && $insider->end == $outsider->end) {
        if ($insider->title === 'ساعت ثبت شده') {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {  [   }]
            if ($insider->start > $outsider->start) {
              $insider = '';
              break;
            } else {
              $outsider = '';
              continue;
            }
          } else {
            // |    {   |}
            if ($insider->start > $outsider->start) {
              $outsider->end = $insider->start;
              continue;
            } else {
              $outsider = '';
              continue;
            }
          }
        } else {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {    |     }|
            if ($insider->start > $outsider->start) {
              $insider = '';
              break;
            } else {
              $insider->end = $outsider->start;
              continue;
            }
          } else {
            // |    /     |/
            if ($insider->start > $outsider->start) {
              $insider = '';
              break;
            } else {
              $outsider = '';
              continue;
            }
          }
        }
      } elseif ($insider->start == $outsider->end) {
        if ($insider->title === 'ساعت ثبت شده') {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {}[]
            $insider->start = $outsider->start;
            $outsider = '';
            continue;
          } else {
            // ||{}
            continue;
          }
        } else {
          if ($outsider->title === 'ساعت ثبت شده') {
            // {}||
          } else {
            // ||//
            $insider->start = $outsider->start;
            $outsider = '';
            continue;
          }
        }
      } elseif ($insider->end == $outsider->start) {
        if ($insider->title === 'ساعت ثبت شده') {
          if ($outsider->title === 'ساعت ثبت شده') {
            // []{}
            $insider->start = $outsider->start;
            $outsider = '';
            continue;
          } else {
            // {}||
          }
        } else {
          if ($outsider->title === 'ساعت ثبت شده') {
            // ||{}
          } else {
            // //||
            $insider->start = $outsider->start;
            $outsider = '';
            continue;
          }
        }
      }
    }
  }
}
 ?>
