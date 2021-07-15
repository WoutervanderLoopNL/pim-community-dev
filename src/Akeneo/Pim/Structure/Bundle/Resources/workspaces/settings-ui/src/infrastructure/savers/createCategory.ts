import {LocaleCode} from "@akeneo-pim-community/shared";

const Routing = require('routing');

const ROUTE_NAME = 'pim_enrich_categorytree_create';

type ValidationErrors = {
  [fieldCode: string]: string;
};

const createCategory = async (code: string, parent?: string, locale?: LocaleCode, label?: string): Promise<ValidationErrors> => {
  const response = await fetch(Routing.generate(ROUTE_NAME), {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      Accept: 'application/json',
    },
    body: JSON.stringify({
      code: code,
      labels: {
        // @ts-ignore
        [locale]: label,
      },
      parent: parent
    }),
  });

  if (!response.ok) {
    return await response.json();
  }

  return {};
};

export {createCategory, ValidationErrors};
