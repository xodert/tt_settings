<?php

namespace Xodert\ServiceRepository\Enums;

enum RepositoryParamEnum: string
{
    case SELECT = 'select';
    case WITH = 'with';
    case LIMIT = 'limit';
    case WITH_COUNT = 'withCount';
    case WHERE = 'where';
    case WHERE_IN = 'whereIn';
    case WHEN = 'when';
    case WHERE_HAS = 'whereHas';
}
