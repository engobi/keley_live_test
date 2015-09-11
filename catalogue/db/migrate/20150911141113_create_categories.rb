class CreateCategories < ActiveRecord::Migration
  def change
    create_table :categories do |t|
      t.text :nom

      t.timestamps
    end
  end
end
