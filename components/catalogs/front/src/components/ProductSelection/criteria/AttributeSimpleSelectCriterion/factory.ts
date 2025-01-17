import {AttributeSimpleSelectCriterionState} from './types';
import {Operator} from '../../models/Operator';

export default (state?: Partial<AttributeSimpleSelectCriterionState>): AttributeSimpleSelectCriterionState => {
    if (!state?.field) {
        throw Error('You need to specific the attribute code when calling the attribute criterion factory');
    }

    return {
        field: state.field,
        operator: state?.operator ?? Operator.IN_LIST,
        value: state?.value ?? [],
        locale: state?.locale ?? null,
        scope: state?.scope ?? null,
    };
};
